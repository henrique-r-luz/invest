<?php

use miloschuman\highcharts\Highcharts;
use yii\helpers\Html;
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

 <?= Html::button('<i class="fa fa-eye-slash"></i> Ocutar Todos', ['class' => 'btn btn-success', 'id'=>'ocultar']) ?>
   <?= Html::button(' <i class="fa fa-eye"></i> Mostra Todos', ['class' => 'btn btn-info','id'=>'mostrar']) ?>
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
              
           ] 
        ],
        'series' => $graficoAno,
    ]
])
?>

<?php $this->registerJs(
        
          "var mostraTudo = document.getElementById('mostrar');"
        . "var ocultaTudo = document.getElementById('ocultar');"
        . " var chart = $('#nome').highcharts();"
        . "var series = chart.series;"
        . "mostraTudo.onclick = function() {"
          . "     series.forEach(function(item,index){"
        . "        item.setVisible(true,false);"
        . "     });"
        . "};"
        . "ocultaTudo.onclick = function() {"
        . "     series.forEach(function(item,index){"
        . "        item.setVisible(false,false);"
        . "     });"
        . "};"
      
        ,
        View::POS_READY
        
);
?>
