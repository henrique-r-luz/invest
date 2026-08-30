<?php
/* @var $this yii\web\View */

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\helpers\Url;
use kartik\select2\Select2;

$this->title = 'Patrimônio';

// Item da navbar com o seletor de investidor. Fica escondido no corpo da
// página e é movido via JS para dentro da ul.navbar-nav.ml-auto do layout,
// para não alterar o navbar.php compartilhado por todo o sistema.
?>
<li id="investidor-nav-item" class="nav-item d-flex align-items-center" style="display:none;flex:1 1 auto;padding-top:6px;">
    <div style="flex:1 1 auto;">
        <?= Select2::widget([
            'name' => 'investidor_id',
            'value' => $investidorId,
            'data' => $investidores,
            'options' => [
                'id' => 'investidor-id-select',
                'placeholder' => 'Investidor',
            ],
            'pluginOptions' => [
                'allowClear' => true,
                'width' => '100%',
            ],
        ]) ?>
    </div>
</li>
<?php
$reloadUrl = Url::to(['site/index']);
$js = <<<JS
var \$item = $('#investidor-nav-item').detach();
var \$navLeft = $('.main-header .navbar-nav').not('.ml-auto').first();
\$navLeft.css('flex', '1 1 auto');
\$item.show().appendTo(\$navLeft);
$('#investidor-id-select').on('change', function() {
    var investidorId = $(this).val();
    var url = '{$reloadUrl}';
    if (investidorId) {
        url += '?investidor_id=' + encodeURIComponent(investidorId);
    }
    window.location.href = url;
});
JS;
$this->registerJs($js);
$this->registerCss(<<<CSS
#investidor-id-select + .select2-container .select2-selection {
    border-radius: 20px !important;
}
CSS
);
?>

<div class="row">
    <div class="col-lg-3">
        <div class="card-info card card-outline" >
            <?= $this->render('@app/views/site/graficos/patrimonio_categoria', ['dadosCategoria' => $dadosCategoria]) ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card-info card card-outline">
            <?= $this->render('@app/views/site/graficos/patrimonio_tipo', ['dadosTipo' => $dadosTipo]) ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card-info card card-outline">
            <?= $this->render('@app/views/site/graficos/patrimonio_pais', ['dadosPais' => $dadosPais]) ?>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card-info card card-outline">
            <?= $this->render('@app/views/site/graficos/acoes_pais', ['dadosAcoesPais' => $dadosAcoesPais]) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-green"><i class="fa fa-dollar-sign "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Valor Invest.</span>
                <span class="info-box-number"> <?= $patrimonioBruto ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-blue"><i class="fa fa-briefcase "></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Aportes</span>
                <span class="info-box-number"><?= $valorCompra ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
    <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-yellow"><i class="fa fa-hand-holding-usd"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Lucro Bruto</span>
                <span class="info-box-number"><?= $lucro_bruto ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
     <div class="col-md-3 col-sm-3 col-xs-12">
        <div class="info-box">
            <!-- Apply any bg-* class to to the icon to color it -->
            <span class="info-box-icon bg-olive"><i class="fa fa-arrow-down"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Proventos</span>
                <span class="info-box-number"><?= $proventos ?></span>
            </div><!-- /.info-box-content -->
        </div><!-- /.info-box -->
    </div>
</div>
<div class="row ">
    <div class="col-lg-12">
        <div class="card-info card card-outline">
            <?= $this->render('@app/views/site/graficos/ativos_detalhados', ['dadosAtivo' => $dadosAtivo]) ?>
        </div>
    </div>

</div>
<div class="row ">
    <div class="col-lg-6">
        <div class="card-info card card-outline">
            <?= $this->render('@app/views/site/graficos/acoes_totais', ['dadosAcoes' => $dadosAcoes]) ?>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card-info card card-outline">
            <?= $this->render('@app/views/site/graficos/fiis_totais', ['dadosFiis' => $dadosFiis]) ?>
        </div>
    </div>

</div>

