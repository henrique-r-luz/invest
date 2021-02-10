<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
use yii\web\View;
?>


<?=


Highcharts::widget([
    'id' => 'histograma',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [
        'chart' => [
            'type' => 'column',
        //'width' => 300
        ],
        'title' => [
            'text' => 'Histograma',
        ],
        'xAxis' => [
            'categories' => $labelClasse
        ],
        'yAxis' => [
            'title' => ['text' => 'Frequência']
        ],
        'plotOptions' => [
            'column' => [
                'pointPadding' => 0,
                'borderWidth' => 1,
                'groupPadding' => 0,
                'shadow' => false
            ]
        ],
        'series' => [
           // 'type'=>'column',
            ['name' => $model->atributo,
                'data' => $histogramaClasse
               // 'data'=>[1 , 2 , 1,  1,  4,  11,  14000,  795,90, 20,23,25,111,1516,15,  66,  14,  15,  6,  3 ]
            ]
        ]
    ]
])
?>

