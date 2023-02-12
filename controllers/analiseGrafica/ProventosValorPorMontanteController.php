<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\analiseGrafica;

use yii\web\Controller;
use app\models\analiseGrafica\ProventosValorPorMontante;

/**
 * Description of LucroPrejuizoController
 *
 * @author henrique
 */
class ProventosValorPorMontanteController extends Controller
{

    public function actionIndex()
    {
        $dadosGraficoLucroPrejuizo = new ProventosValorPorMontante();
        $dados = $dadosGraficoLucroPrejuizo->getDadosProventosValorPorMontante();
        return $this->render(
            'index',
            [
                'dados' => $dados,
            ]
        );
    }
}
