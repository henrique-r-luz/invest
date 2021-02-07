<?php
/* @var $this yii\web\View */

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

$this->title = 'Patrimônio';
//print_r($dadosCategoria);
//exit();
?>

<div class="row ">
    <div class="col-lg-3" >
        <div class="box box-info" height="50%">
            <?= $this->render('@app/views/site/graficos/patrimonio_categoria', ['dadosCategoria' => $dadosCategoria]) ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="box box-info">
            <?= $this->render('@app/views/site/graficos/patrimonio_tipo', ['dadosTipo' => $dadosTipo]) ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="box box-info">
            <?= $this->render('@app/views/site/graficos/patrimonio_pais', ['dadosPais' => $dadosPais]) ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="box box-info">
            <?= $this->render('@app/views/site/graficos/acoes_pais', ['dadosPais' => $dadosPais]) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-green"><i class="fa fa-usd "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Valor Invest.</span>
                <span class="info-box-number"> <?= $patrimonioBruto ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-briefcase "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Aportes</span>
                <span class="info-box-number"><?= $valorCompra ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-yellow"><i class="fa fa-line-chart"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Lucro Bruto</span>
                <span class="info-box-number"><?= $lucro_bruto ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
</div>
<div class="row ">
    <div class="col-lg-12">
        <div class="box box-info">
            <?= $this->render('@app/views/site/graficos/ativos_detalhados', ['dadosAtivo' => $dadosAtivo]) ?>
        </div>
    </div>

</div>
<div class="row ">
    <div class="col-lg-12">
        <div class="box box-info">
            <?= $this->render('@app/views/site/graficos/acoes_totais', ['dadosAcoes' => $dadosAcoes]) ?>
        </div>
    </div>

</div>

