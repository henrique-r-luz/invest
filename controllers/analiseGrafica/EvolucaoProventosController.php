<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\analiseGrafica;

use app\models\analiseGrafica\EvolucaoProventos;
use \yii\base\Controller;

/**
 * Description of EvolucaoPatrimonioController
 *
 * @author henrique
 */
class EvolucaoProventosController extends Controller {

    //put your code here


    public function actionIndex() {
        $dadosGraficoProventos = new EvolucaoProventos();
        return $this->render('index',
                        [
                            'dados' =>  $dadosGraficoProventos,
                            
                        ]
        );
    }

}
