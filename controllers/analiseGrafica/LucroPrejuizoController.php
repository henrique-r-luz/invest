<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\analiseGrafica;

use \yii\web\Controller;
use app\models\analiseGrafica\LucroPrezuijo;

/**
 * Description of LucroPrejuizoController
 *
 * @author henrique
 */
class LucroPrejuizoController extends Controller {

    public function actionIndex() {
        $dadosGraficoLucroPrejuizo = new LucroPrezuijo();
        $dados = $dadosGraficoLucroPrejuizo->getDadosLucroPrejuizo();
        return $this->render('index',
                        [
                            'dados' => $dados,
                        ]
        );
    }

}
