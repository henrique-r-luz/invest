<?php

use miloschuman\highcharts\Highcharts;
use yii\web\View;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


?>

<?=
Highcharts::widget([
    'id' => 'evolucao_patrimonio',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [

        'title' => [
            'text' => 'Evolução',
        ],
        'legend' => [
            'layout' => 'vertical',
            'align' => 'right',
            'verticalAlign' => 'middle'
        ],
        'xAxis' => [
            'categories' => $dados->getDataTime()
        ],
        'yAxis' => [
            'title' => ['text' => 'Valores']
        ],
        'plotOptions' => [
            'series' => []
        ],
        // 'series' => [['name' => 'graf', 'data' =>[11217.93,1198.93,3604.3599,-1055.34 ]]],
        'series' => $dados->getDadosGrafico(),
    ]
])
?>