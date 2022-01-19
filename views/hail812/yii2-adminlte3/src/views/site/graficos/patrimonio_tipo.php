<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>

<?=

Highcharts::widget([
    'id' => 'grafico-pizza-tipo',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [
        'chart' => [
            'type' => 'pie',
         'height' => 350,
        ],
        'title' => [
            'text' => 'Tipo',
        ],
        'series' => [
            [
                'name' => 'Tipo',
                'data' => $dadosTipo,
                //'size' => 300,
                'showInLegend' => false,
                'dataLabels' => [
                    'enabled' => false,
                    'format' => '<b>{point.name}</b><br>{point.percentage:.1f} %',
                    'distance' => -50,
                    'filter' => [
                        'property' => 'percentage',
                        'operator' => '>',
                        'value' => 4,
                    ]
                ],
                /* 'dataLabels' => [
                  'enabled' => false,
                  'format' => '<span style="font-size:13px">{point.name}: {point.y:f} %'
                  ], */
                'depth' => 100,
                'tooltip' => [
                    'headerFormat' => '',
                    'pointFormat' => '<span >{point.name}</span>: <b>{point.y:f} %</b> do Patrimônio<br/>'
                ],
            ],
        ],
    ]
])
?>

