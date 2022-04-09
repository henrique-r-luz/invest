<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use Throwable;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\OperacoesImport;
use app\models\financas\service\sincroniza\ComponenteOperacoes;
use app\models\financas\service\operacoesImport\OperacoesImportHelp;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

class OperacaoAvenue extends OperacoesImportAbstract
{
    const COMPRA = 'Compra';
    const VENDA = 'Venda';
    private $dataAcao;
    private $itensAtivo;

    protected function getDados()
    {
        echo 'olaaa'.$this->operacoesImport->hash_nome;
        exit();
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo enviado não foi salvo no servidor. ");
        }
        $this->arquivo = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->arquivo[0]);
        foreach ($this->arquivo as $i => $item) {
            if (isset($item[3])) {
                $operacao = explode(" ", $item[3]);
                if ($operacao[0] != self::COMPRA && self::VENDA) {
                    unset($this->arquivo[$i]);
                    continue;
                }
                $this->arquivo[$i][3] = [
                    'operacao' => $operacao[0],
                    'quantidade' => $operacao[2],
                    'acao' => $operacao[3],
                    'valorUnitario' => abs($operacao[6])
                ];
                continue;
            }
            unset($this->arquivo[$i]);
        }
    }


    public  function atualiza()
    {
        try {
            foreach ($this->arquivo as $item) {
                $codigo = $item[3]['acao'];
                $this->itensAtivo = OperacoesImportHelp::getIntemAtivo(['codigo' => $codigo, 'investidor' => $this->operacoesImport->investidor_id]);
                list($d, $m, $y) = explode('/', $item[0]);
                $this->dataAcao = $y . '-' . $m . '-' . $d . ' ' . $item[1];
                if (Operacao::find()->where(['itens_ativos_id' => $this->itensAtivo->id])->andWhere(['data' => $this->dataAcao])->exists()) {
                    continue;
                }
                if (empty($this->itensAtivo)) {
                    continue;
                }
                $operacaoService = OperacoesImportHelp::insereOperacao([
                    'itensAtivo_id' => $this->itensAtivo->id,
                    'quantidade' => $item[3]['quantidade'],
                    'data' => $this->dataAcao,
                    'valor' => abs($item[4]),
                    'operacao' => $item[3]['operacao']
                ]);
                if (!$operacaoService->acaoSalvaOperacao()) {
                    $erros = CajuiHelper::processaErros($operacaoService->getOpereacao()->getErrors()) . '</br>';
                    throw new \Exception($erros);
                } else {
                    $this->dadosJson['operacoes_id'][] = $operacaoService->getOpereacao()->id;
                }
            }
        } catch (Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete()
    {
        OperacoesImportHelp::delete($this->operacoesImport);
    }
}
