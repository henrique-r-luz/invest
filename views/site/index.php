<?php
/* @var $this yii\web\View */

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = 'Patrimônio';
//print_r($dadosCategoria);
//exit();
?>

<div class="row ">
    <div class="col-lg-4">
        <div class="box box-info">
            <?=
            Highcharts::widget([
                'id' => 'grafico-pizza-categoria',
                'scripts' => [
                    'modules/exporting',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'pie',
                    //'width' => 300
                    ],
                    'title' => [
                        'text' => 'Patrimônio por Categoria',
                    ],
                    'series' => [
                        [
                            'name' => 'Categorias',
                            'data' => $dadosCategoria,
                            //'size' => 200,
                            'showInLegend' => true,
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
        </div>
    </div>
    <div class="col-lg-5">
        <div class="box box-info">
            <?=
            Highcharts::widget([
                'id' => 'grafico-pizza-tipo',
                'scripts' => [
                    'modules/exporting',
                ],
                'options' => [
                    'chart' => [
                        'type' => 'pie',
                    //'width' => 300
                    ],
                    'title' => [
                        'text' => 'Patrimônio po Tipo',
                    ],
                    'series' => [
                        [
                            'name' => 'Tipo',
                            'data' => $dadosTipo,
                            //'size' => 300,
                            'showInLegend' => true,
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
        </div>
    </div>
    <div class="col-lg-3">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-green"><i class="fa  fa-usd "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Valor Invest.</span>
                <span class="info-box-number"> <?= $patrimonioBruto ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->

        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-briefcase "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Aportes</span>
                <span class="info-box-number"><?= $valorCompra ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-yellow"><i class="fa fa-line-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Lucro</span>
                <span class="info-box-number"><?= $valorCompra ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
</div>
<div class="row ">
    <div class="col-lg-12">
        <div class="box box-info">
            <?=
            Highcharts::widget([
                'id' => 'grafico-pizza-ativos2',
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
        </div>
    </div>

</div>
<div class="row ">
    <div class="col-lg-12">
        <div class="box box-info">
            <?=
            Highcharts::widget([
                'id' => 'grafico-pizza-acoes',
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
                        'text' => 'Açoes',
                    ],
                    'series' => [
                        [
                            'name' => 'Ações',
                            'data' => $dadosAcoes,
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
        </div>
    </div>

</div>

