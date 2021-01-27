<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use Smalot\PdfParser\Parser;
use Yii;
/**
 * Description of BancoInter
 *
 * @author henrique
 */
class BancoInter extends OperacoesAbstract {

    //put your code here
    protected function getDados() {
       $parser = new Parser();
        $pdf = $parser->parseFile(Yii::$app->params['bot'] . '/banco_inter.pdf');
        $text = $pdf->getText();
        echo $text;
        exit();
    }

    public function atualiza() {
        
    }

}
