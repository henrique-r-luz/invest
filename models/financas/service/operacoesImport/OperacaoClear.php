<?php

namespace app\models\financas\service\operacoesImport;

use app\models\financas\OperacoesImport;
use Yii;
use app\models\financas\service\sincroniza\ComponenteOperacoes;
use app\models\financas\service\operacoesImport\OperacoesAbstract;

class OperacaoClear extends OperacoesAbstract
{

    protected function getDados(){

        $filePath = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $this->operacoesImport->hash_nome . '.' . $this->operacoesImport->extensao;
       

        $erros = 'Erro na criação das Operações: ';
        if (!file_exists($filePath)) {
            throw new \Exception("O arquivo envado não foi salvo no servidor. ");
        }
        //$csv = array_map('str_getcsv', file('/vagrant/bot/orders.csv'));
        $this->arquivo = array_map(function ($v) use ($filePath) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($filePath));
        }, file($filePath));
        unset($this->arquivo[0]);

    }

    public  function atualiza(){

    }

}
