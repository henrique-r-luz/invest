<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\OperacoesImport;
use app\lib\config\atualizaAtivos\ComponenteOperacoes;
use app\models\financas\AtualizaNu;
use app\models\financas\service\operacoesImport\OperacoesImportAbstract;

/**
 * Description of CotacaoEasy
 *
 * @author henrique
 */
class OperacaoNu extends OperacoesImportAbstract
{

    private $csv;

    //put your code here
    protected function getDados()

    {
        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
        if (!file_exists($filePath)) {
            throw new InvestException("O arquivo NU enviado não foi salvo no servidor. ");
        }

        $this->csv = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->csv[0]);
        unset($this->csv[1]);
    }

    public function atualiza()
    {
        /**
         * tem que cria uma tabela pra registrar as atualizações,
         * para quando o registro for exclído 
         */
        foreach ($this->csv as $titulo) {
            $codigo = $titulo[1] . '-' . $titulo[3] . '-' . $titulo[2];
            $itensAtivos = ItensAtivo::find()
                ->joinWith(['ativos'])
                ->where(['codigo' => $codigo])->all();
            foreach ($itensAtivos as $itensAtivo) {
                $this->salvaValoresAtigos($itensAtivo);
                if ($itensAtivo == null) {
                    $erros = ' o codigo do itensAtivo:' . $codigo . ' não existe</br>';
                    throw new InvestException($erros);
                }
                $itensAtivo->valor_bruto = floatval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[6]))));
                $itensAtivo->valor_liquido = floatval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[7]))));
                if (!$itensAtivo->save()) {
                    $erros = CajuiHelper::processaErros($itensAtivo->getErrors());
                    throw new InvestException($erros);
                }
            }
        }
    }

    private function salvaValoresAtigos($itensAtivo)
    {
        //falta itens aptivo
        $atualizaNu =  new  AtualizaNu();
        $atualizaNu->valor_bruto_antigo = $itensAtivo->valor_bruto;
        $atualizaNu->valor_liquido_antigo = $itensAtivo->valor_liquido;
        $atualizaNu->operacoes_import_id = $this->operacoesImport->id;
        $atualizaNu->itens_ativo_id = $itensAtivo->id;
        if (!$atualizaNu->save()) {
            $erros = CajuiHelper::processaErros($atualizaNu->getErrors());
            throw new InvestException($erros);
        }
    }

    public  function delete()
    {
        $atualizaNus = AtualizaNu::find()->where(['operacoes_import_id' => $this->operacoesImport->id])->all();
        foreach ($atualizaNus as $atualizaNu) {
            $this->retornaValorAntigo($atualizaNu->itensAtivo, $atualizaNu->valor_bruto_antigo, $atualizaNu->valor_liquido_antigo);
            if (!$atualizaNu->delete()) {
                throw new InvestException('Não pode remover os Itens atualiza Nu');
            }
        }
        OperacoesImportHelp::delete($this->operacoesImport);
    }


    private function retornaValorAntigo($itensAtivo, $valorBruto, $valorLiquido)
    {
        $itensAtivo->valor_bruto = $valorBruto;
        $itensAtivo->valor_liquido = $valorLiquido;
        if (!$itensAtivo->save()) {
            $erros = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erros);
        }
    }
}
