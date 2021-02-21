<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\analiseGrafica;

use app\models\analiseGrafica\ProventosPorAtivos;
use yii\web\Controller;

/**
 * Description of LucroPrejuizoController
 *
 * @author henrique
 */
class ProventosPorAtivoController extends Controller {

    public function actionIndex() {
        $dadosGraficoLucroPrejuizo = new ProventosPorAtivos();
        $dados = $dadosGraficoLucroPrejuizo->getDadosProventos();
        return $this->render('index',
                        [
                            'dados' => $dados,
                        ]
        );
    }

}
