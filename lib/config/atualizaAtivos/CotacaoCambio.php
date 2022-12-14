<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\config\atualizaAtivos;

use Yii;
use yii\db\Exception;
use app\lib\helpers\InvestException;

/**
 * Description of CotacaoCambio
 *
 * @author henrique
 */
class CotacaoCambio extends OperacoesAbstract
{
    //put your code here

    private $csv;


    public function atualiza()
    {
        $cambio = [];
        foreach ($this->csv as $moeda) {
            $cambio[$moeda[0]] = $moeda[1];
        }
        return $cambio;
    }

    public function getDados()
    {
        $file = Yii::$app->params['bot'] . '/cambio.csv';
        if (!file_exists($file)) {
            throw new InvestException("Não foi possível encontrar o arquivo de câmbio");
        }
        $this->csv = array_map('str_getcsv', file($file));
        unset($this->csv[0]);
    }
}
