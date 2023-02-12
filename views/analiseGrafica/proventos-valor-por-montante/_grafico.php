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
    'id' => 'proventos_por_ativo',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [
        'chart' => [
            'type' => 'column',
            //'width' => 300
        ],
        'title' => [
            'text' => 'Proventos/Valor_Atual',
        ],
        /* 'legend' => [
          'layout' => 'vertical',
          'align' => 'right',
          'verticalAlign' => 'middle'
          ], */
        'xAxis' => [
            'type' => 'category'
        ],
        'yAxis' => [
            'title' => ['text' => 'Valores']
        ],
        'legend' => [
            'enabled' => false
        ],

        'plotOptions' => [
            'series' => [
                //'borderWidth'=> 0,
                /* 'dataLabels'=> [
                'enabled'=> true,
                'format'=> '<span>{point.por}%</span>'
            ]*/]
        ],

        'tooltip' => [
            'shared' => true,
            'headerFormat' => '<span style="font-size: 15px"><b>{point.point.name}</b></span><br/>',
            'pointFormat' => '<span>P/VA:</span>  {point.y} Pontos<br/>'
        ],
        // 'series' => [['name' => 'graf', 'data' =>[11217.93,1198.93,3604.3599,-1055.34 ]]],
        'series' => [$dados],
    ]
])
?>