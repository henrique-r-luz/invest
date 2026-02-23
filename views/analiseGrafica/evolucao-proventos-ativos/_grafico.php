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
    'id' => 'evolucao_proventos_ativos',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [
        // 'chart' => [
        //     'type' => 'container',
        //'width' => 300
        //],
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

        //'series' => [['name' => 'proventos', 'data' => [0 => 1, 1 => 2, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11]]],
        'series' => $dados->getDadosGrafico(),
    ]
])
?>