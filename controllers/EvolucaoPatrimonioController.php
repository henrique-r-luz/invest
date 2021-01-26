<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use \app\models\graficos\EvolucaoPatrimonio;
use \yii\base\Controller;

/**
 * Description of EvolucaoPatrimonioController
 *
 * @author henrique
 */
class EvolucaoPatrimonioController extends Controller {

    //put your code here


    public function actionIndex() {
        $dadosGraficoPratrimonio = new EvolucaoPatrimonio();
        $dadosGraficoPratrimonio->getDados();
        return $this->render('index',
                        [
                            'dados' => $dadosGraficoPratrimonio,
                        ]
        );
    }

}
