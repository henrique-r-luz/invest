<?php
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>
<?=

Highcharts::widget([
    'id' => 'grafico-pizza-ativos-detalhados',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [
        'chart' => [
            'type' => 'pie',
        //'heigth' => 600
        //  'height'=>'100%',
        //  'width'=>'100%',
        ],
        'title' => [
            'text' => 'Ativos',
        ],
        'series' => [
            [
                'name' => 'Ativos',
                'data' => $dadosAtivo,
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