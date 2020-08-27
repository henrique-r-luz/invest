<?php

use miloschuman\highcharts\Highcharts;
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
   // 'id' => 'grafico-pizza-categoria',
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
        'series' => $graficoAno,
    ]
])
?>

