<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use yii\base\UserException;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\models\financas\OperacoesImport;
use app\models\financas\service\OperacaoService;
use app\models\financas\service\sincroniza\ComponenteOperacoes;


class OperacaoClear extends OperacoesImportAbstract
{
    private $linha;
    private $itensAtivo;
    private $dataAcao;

    protected function getDados()
    {

        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo envado não foi salvo no servidor. ");
        }
        $this->arquivo = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->arquivo[0]);
    }

    public  function atualiza()
    {
        try {
            foreach ($this->arquivo as $id => $linha) {
                $this->linha = $linha;
                $codigo = substr($linha[1], 0, 5); //str_replace("F", "", $linha[1]);
                $this->itensAtivo = $this->getIntemAtivo($codigo); 
                if (empty($this->itensAtivo)) {
                    $codigo = $linha[1]; //str_replace("F", "", $linha[1]);
                    $this->itensAtivo = $this->getIntemAtivo($codigo);
                    if (empty($this->itensAtivo)) {
                        continue;
                    }
                }
                list($data, $hora) = explode(" ", $linha[11]);
                list($d, $m, $y) = explode('/', $data);
                $this->dataAcao = $y . '-' . $m . '-' . $d . ' ' . $hora;

                if (Operacao::find()->where(['itens_ativos_id' => $this->itensAtivo->id])->andWhere(['data' => $this->dataAcao])->exists()) {
                    continue;
                }

                if ($this->itensAtivo != null && ($linha[15] == '' || $linha[15] == null)) {

                    $operacaoService = $this->insereOperacao();
                    if (!$operacaoService->acaoSalvaOperacao()) {
                        $erros = CajuiHelper::processaErros($operacaoService->getOpereacao()->getErrors()) . '</br>';
                        throw new \Exception($erros);
                    } else {
                        $this->dadosJson['operacoes_id'][] = $operacaoService->getOpereacao()->id;
                    }
                }
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }


    private function getIntemAtivo($codigo){
        return ItensAtivo::find()
        ->joinWith(['ativos'])
        ->where(['ativo.codigo' => $codigo])
        ->andWhere(['investidor_id' => $this->operacoesImport->investidor_id])
        ->one();
    }


    private function insereOperacao(){
        $operacao = new Operacao();
        $operacao->itens_ativos_id = $this->itensAtivo->id;
        $operacao->quantidade = $this->linha[8];
        $operacao->data = $this->dataAcao;
        $operacao->valor = $this->linha[10] * $this->linha[8];
        if (trim(strtolower($this->linha[3])) == 'venda') {
            $operacao->tipo = 0;
        } else {
            $operacao->tipo = 1;
        }
        $operacaoService = new OperacaoService($operacao);
        return $operacaoService;
    }

    public function delete()
    {
        OperacoesImportHelp::delete($this->operacoesImport);
    }
}
