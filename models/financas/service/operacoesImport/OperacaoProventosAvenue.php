<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use DateTime;
use app\lib\CajuiHelper;
use app\models\financas\Proventos;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;
use app\lib\dicionario\ProventosMovimentacao;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

class OperacaoProventosAvenue extends OperacoesImportAbstract
{
    const CREDITO_DIVIDENDOS = 'Crédito dividendos';
    const RETENCAO_IMPOSTOS  = 'Retenção Impostos sobre Dividendos';

    /**
     * Lê o PDF da Avenue usando smalot/pdfparser e armazena o texto extraído.
     */
    protected function getDados()
    {
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new InvestException("O arquivo enviado não foi salvo no servidor.");
        }

        $parser = new \Smalot\PdfParser\Parser();
        $pdf    = $parser->parseFile($filePath);
        $this->arquivo = $pdf->getText();
    }

    /**
     * Processa os dividendos extraídos do PDF e insere na tabela proventos.
     * Valor inserido = Crédito dividendos − Retenção Impostos (por ativo).
     */
    public function atualiza()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $dividendos  = $this->parseDividendos();

            if (empty($dividendos)) {
                throw new InvestException("Nenhum dividendo encontrado no PDF.");
            }

            foreach ($dividendos as $ticker => $dados) {
                $valorLiquido = $dados['credito'] - $dados['retencao'];

                if ($valorLiquido <= 0) {
                    continue;
                }

                $data = DateTime::createFromFormat('d/m/Y', $dados['data'])->format('Y-m-d') . ' 20:00:00';

                // Verifica se o provento já existe para não duplicar
                if (Proventos::find()
                    ->innerJoin('public.itens_ativo', 'itens_ativo.id = proventos.itens_ativos_id')
                    ->innerJoin('public.ativo', 'ativo.id = itens_ativo.ativo_id')
                    ->where(['UPPER(ativo.codigo)' => strtoupper($ticker)])
                    ->andWhere(['proventos.data' => $data])
                    ->andWhere(['itens_ativo.investidor_id' => $this->operacoesImport->investidor_id])
                    ->exists()
                ) {
                    continue;
                }

                $itensAtivo = ItensAtivo::find()
                    ->innerJoin('ativo', 'itens_ativo.ativo_id = ativo.id')
                    ->where(['UPPER(ativo.codigo)' => strtoupper($ticker)])
                    ->andWhere(['investidor_id' => $this->operacoesImport->investidor_id])
                    ->one();

                if (empty($itensAtivo)) {
                    throw new InvestException("Ativo não encontrado na carteira: {$ticker}");
                }

                $provento = new Proventos();
                $provento->itens_ativos_id = $itensAtivo->id;
                $provento->valor           = $valorLiquido;
                $provento->data            = $data;
                $provento->movimentacao    = ProventosMovimentacao::getId(ProventosMovimentacao::Dividendo);

                if (!$provento->save()) {
                    $erro = CajuiHelper::processaErros($provento->getErrors());
                    $transaction->rollBack();
                    throw new InvestException($erro);
                }

                $this->dadosJson['operacoes_id'][] = $provento->id;
            }

            $transaction->commit();
        } catch (InvestException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Faz o parse do texto do PDF e retorna os dividendos agrupados por ticker.
     *
     * Formato esperado no texto extraído (após normalização):
     *   DIVIDEND DD/MM/YYYY C Crédito dividendos TICKER $VALOR
     *   DIVIDEND DD/MM/YYYY C Retenção Impostos sobre Dividendos TICKER $VALOR
     *
     * @return array ['TICKER' => ['credito' => float, 'retencao' => float, 'data' => string]]
     */
    private function parseDividendos(): array
    {
        // O smalot/pdfparser extrai o PDF da Avenue com espaços inseridos dentro
        // das palavras (ex: "D IV ID EN D", "Cré d ito"). Por isso removemos TODOS
        // os espaços/quebras de linha antes de aplicar os regex.
        // Resultado: "DIVIDEND17/02/2026CCréditodividendosO$34.05"
        $text = preg_replace('/\s+/', '', $this->arquivo);

        $dividendos = [];

        // "CCréditodividendos" = "C" (tipo de conta) + "Crédito dividendos" sem espaços
        preg_match_all(
            '/DIVIDEND(\d{2}\/\d{2}\/\d{4})CCr[eé]ditodividendos([A-Z]{1,5})\$?([\d,]+\.?\d*)/u',
            $text,
            $creditoMatches,
            PREG_SET_ORDER
        );

        foreach ($creditoMatches as $match) {
            $ticker = $match[2];
            $valor  = floatval(str_replace(',', '', $match[3]));
            if (!isset($dividendos[$ticker])) {
                $dividendos[$ticker] = ['credito' => 0, 'retencao' => 0, 'data' => null];
            }
            $dividendos[$ticker]['credito'] += $valor;
            $dividendos[$ticker]['data']     = $match[1];
        }

        // "CReten.{1,4}oImpostossobreDividendos" = "C" (tipo de conta) +
        // "Retenção Impostos sobre Dividendos" sem espaços.
        // O .{1,4} cobre os caracteres "çã" de "Retenção" e possíveis variações de encoding.
        preg_match_all(
            '/DIVIDEND(\d{2}\/\d{2}\/\d{4})CReten.{1,4}oImpostossobreDividendos([A-Z]{1,5})\$?([\d,]+\.?\d*)/u',
            $text,
            $retencaoMatches,
            PREG_SET_ORDER
        );

        foreach ($retencaoMatches as $match) {
            $ticker = $match[2];
            $valor  = floatval(str_replace(',', '', $match[3]));
            if (!isset($dividendos[$ticker])) {
                $dividendos[$ticker] = ['credito' => 0, 'retencao' => 0, 'data' => null];
            }
            $dividendos[$ticker]['retencao'] += $valor;
            if ($dividendos[$ticker]['data'] === null) {
                $dividendos[$ticker]['data'] = $match[1];
            }
        }

        return $dividendos;
    }

    public function delete()
    {
        $transaction = null;
        try {
            $transaction = Yii::$app->db->beginTransaction();

            $operacoes   = json_decode($this->operacoesImport->lista_operacoes_criadas_json, true);
            if (!isset($operacoes['operacoes_id'])) {
                $this->operacoesImport->deleteUpload();
                $transaction->commit();
                return true;
            }
            foreach ($operacoes['operacoes_id'] as $operacao) {
                $objOperacao = Proventos::findOne($operacao);
                if (!empty($objOperacao)) {
                    $objOperacao->delete();
                }
            }
            $this->operacoesImport->deleteUpload();
            $transaction->commit();
        } catch (\Exception $e) {
            if ($transaction !== null) {
                $transaction->rollBack();
            }
            throw new InvestException("Erro ao remover operação Import: " . $e->getMessage());
        }
    }
}
