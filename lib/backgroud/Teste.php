<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Teste
 *
 * @author henrique
 */
namespace app\lib\backgroud;

use app\models\AcaoBolsa;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class Teste extends BaseObject implements JobInterface {
    
    public function execute($queue)
    {
         
        $empresaBolsa = new AcaoBolsa();
        $empresaBolsa->nome = 'teste fila';
        $emoresaBolsa->codigo = 'ZZZZ';
        $empresaBolsa->setor='fila';
        $emoresaBolsa->cnpj = 'cnpj';
        $emoresaBolsa->save();
    }
}
