<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>

 <?=
            Highcharts::widget([
                'id' => 'grafico-pizza-acoes-pais',
                'scripts' => [
                    'modules/exporting',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'pie',
                        'height' => 350,
                    ],
                    'title' => [
                        'text' => 'Ações Por País',
                    ],
                    'series' => [
                        [
                            'name' => 'Tipo',
                            'data' => $dadosAcoesPais,
                            //'size' => 300,
                            'showInLegend' => false,
                            'dataLabels' => [
                                'enabled' => false,
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

