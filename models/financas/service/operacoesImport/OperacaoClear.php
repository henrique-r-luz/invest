<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;
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
           
            foreach ($this->arquivo as $id => $linha) {
               
                $this->linha = $linha;
                $codigo = substr($linha[1], 0, 5); //str_replace("F", "", $linha[1]);
                $this->itensAtivo = OperacoesImportHelp::getIntemAtivo(['codigo' => $codigo, 'investidor' => $this->operacoesImport->investidor_id]); 
                if (empty($this->itensAtivo)) {
                    $codigo = $linha[1]; //str_replace("F", "", $linha[1]);
                    $this->itensAtivo = OperacoesImportHelp::getIntemAtivo(['codigo' => $codigo, 'investidor' => $this->operacoesImport->investidor_id]);
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
               
                if ($this->itensAtivo != null) {

                    $operacaoService =  OperacoesImportHelp::insereOperacao([
                        'itensAtivo_id' => $this->itensAtivo->id,
                        'quantidade' => $this->linha[8],
                        'data' => $this->dataAcao,
                        'valor' => $this->linha[10] * $this->linha[8],
                        'operacao' => $this->linha[3]
                    ]);
                    if (!$operacaoService->acaoSalvaOperacao()) {
                        $erros = CajuiHelper::processaErros($operacaoService->getOpereacao()->getErrors()) . '</br>';
                        throw new InvestException($erros);
                    } else {
                        $this->dadosJson['operacoes_id'][] = $operacaoService->getOpereacao()->id;
                    }
                }
               
               
            }
        } catch (\Exception $e) {
           
            throw new \Exception($e->getMessage());
        }
    }

    public function delete()
    {
        OperacoesImportHelp::delete($this->operacoesImport);
    }
}
