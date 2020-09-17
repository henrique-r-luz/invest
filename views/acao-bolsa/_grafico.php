<?php

use miloschuman\highcharts\Highcharts;
use yii\web\View;
//print_r($graficoAno[0]);
//exit();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$data = $graficoAno[0];
unset($graficoAno[0]);
$graficoAno = array_values($graficoAno);
//print_r($graficoAno);
//exit();
?>


<?=

Highcharts::widget([
    'id' => 'nome',
    'scripts' => [
        'modules/exporting',
    ],
    'options' => [
        // 'chart' => [
        //     'type' => 'container',
        //'width' => 300
        //],
        'title' => [
            'text' => 'Indicadores',
        ],
        'legend' => [
            'layout' => 'vertical',
            'align' => 'right',
            'verticalAlign' => 'middle'
        ],
        'xAxis' => [
            'categories' => $data['data']
        ],
        'yAxis' => [
            'title' => ['text' => 'Valores']
        ],
        'plotOptions'=>[
           'series'=>[
               'events'=>[
                   'legendItemClick'=>"function(){alert('ola')}"
               ]
           ] 
        ],
        'series' => $graficoAno,
    ]
])
?>

<?php $this->registerJs(
        
        "var teste = $('.highcharts-legend-item')[0];"
        . "teste.onclick = function(){alert('ola');};"
        //. "var legendas = chart.series;"
       // . "console.log(chart.event);"
        //. "console.log(legendas);"
        /*. "for (legenda in legendas) {
            chart.series[legenda].onclick = function(){alert('olaaa')};
            console.log(chart.series[legenda].eventOptions.legendItemClick);
          }"*/
        ,
        View::POS_READY
        
);
?>
