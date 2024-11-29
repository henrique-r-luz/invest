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
use app\lib\config\atualizaAtivos\ComponenteOperacoes;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

class OperacaoProventosAvenue extends OperacoesImportAbstract
{
    const COMPRA = 'Compra';
    const VENDA = 'Venda';
    const DIVIDENDOS = 'Dividendos';
    const RETENCAO_IMPOSTOS = 'Retenção Impostos sobre Dividendos';


    protected function getDados()
    {
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new InvestException("O arquivo enviado não foi salvo no servidor. ");
        }
        $this->arquivo = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->arquivo[0]);
    }




    public  function atualiza()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $dadosDividendos = $this->dadosComDividendo();

            foreach ($dadosDividendos as $key => $itens) {
                list($codigo, $dataRef) = \explode('_', $key);
                if (Proventos::find()
                    ->innerJoin('public.itens_ativo', 'itens_ativo.id = proventos.itens_ativos_id')
                    ->innerJoin('public.ativo', 'ativo.id = itens_ativo.ativo_id')
                    ->where(['UPPER(ativo.codigo)' => strtoupper(trim($codigo))])
                    ->andWhere(['proventos.data' => $itens['data']])->exists()
                ) {
                    continue;
                }
                $provento = new Proventos();
                $provento->itens_ativos_id =  ItensAtivo::find()
                    ->innerJoin('ativo', 'itens_ativo.ativo_id = ativo.id')
                    ->where(['ativo.codigo' => $codigo])
                    ->andWhere(['investidor_id' => $this->operacoesImport->investidor_id])
                    ->one()
                    ->id;
                $provento->valor = floatval($itens['dividendo_bruto'] - abs($itens['dividendo_desconto']));
                $provento->data = $itens['data'];
                $provento->movimentacao = ProventosMovimentacao::getId(ProventosMovimentacao::Dividendo);
                if (!$provento->save()) {
                    $erro = CajuiHelper::processaErros($provento->getErrors());
                    $transaction->rollBack();
                    throw new InvestException($erro);
                }
                $this->dadosJson['operacoes_id'][] = $provento->id;
            }
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch (InvestException $e) {
            $transaction->rollBack();
            throw $e;
        }
    }



    private function dadosComDividendo()
    {
        $transacoesAvenue = $this->arquivo;
        $dividendos = [];
        foreach ($transacoesAvenue as $linha) {
            $indexTextoDividendo = strpos(trim($linha[3]), trim(self::DIVIDENDOS));
            if ($indexTextoDividendo !== false && $indexTextoDividendo == 0) {
                $codigo =  $this->getCodigoAtivo($linha[3]);
                $dividendos[$codigo . '_' . $linha[0]]['dividendo_bruto'] = $linha[4];
                $date = $linha[2];
                $formattedDate = DateTime::createFromFormat('d/m/Y', $date)->format('Y-m-d') . ' ' . trim($linha[1]) . ':00';
                $dividendos[$codigo . '_' . $linha[0]]['data'] = $formattedDate;
            }
            if (strpos(trim($linha[3]), trim(self::RETENCAO_IMPOSTOS)) !== false) {
                $codigo =  $this->getCodigoAtivo($linha[3]);
                $dividendos[$codigo . '_' . $linha[0]]['dividendo_desconto'] = $linha[4];
            }
        }
        return $dividendos;
    }

    private function getCodigoAtivo($texto)
    {
        $startLimite = strpos($texto, self::DIVIDENDOS);
        $endLimite = strpos($texto, '.');

        if ($startLimite === false) {
            throw new InvestException("Não pode encontrar o código do ativo");
        }

        if ($endLimite === false) {
            throw new InvestException("Não pode encontrar o código do ativo");
        }
        $init = ($startLimite + strlen(self::DIVIDENDOS));
        $substring = substr($texto, ($init), ($endLimite - $init));
        return  trim($substring);
    }


    public function delete()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $operacoes =  json_decode($this->operacoesImport->lista_operacoes_criadas_json, true);
            if (!isset($operacoes['operacoes_id'])) {
                $this->operacoesImport->deleteUpload();
                $transaction->commit();
                return true;
            }
            foreach ($operacoes['operacoes_id'] as $operacao) {
                $objOperacao = Proventos::findOne($operacao);
                $objOperacao->delete();
            }
            $this->operacoesImport->deleteUpload();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new InvestException("Error ao remover operação Import. ");
        }
    }
}
