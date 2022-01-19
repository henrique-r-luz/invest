<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>

 <?=
            Highcharts::widget([
                'id' => 'grafico-pizza-fiis',
                'scripts' => [
                    'modules/exporting',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'pie',
                       // 'height' => 350,
                    ],
                    'title' => [
                        'text' => 'FIIs',
                    ],
                    'series' => [
                        [
                            'name' => 'FIIs',
                            'data' => $dadosFiis,
                            //'size' => 200,
                            'showInLegend' => false,
                            'dataLabels' => [
                                'enabled' => true,
                                'format' => '<span style="font-size:13px">{point.name}: {point.y:f} %'
                            ],
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

