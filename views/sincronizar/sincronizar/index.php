<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use yii\widgets\ActiveForm;
use yii\bootstrap4\Progress;


$this->title = 'Sincroniza Dados';
$this->registerJsFile(
    '@web/js/sincroniza/carregaBotAcoes.js',
    [
        'depends' => [yii\web\YiiAsset::class]
    ]
);

?>
<div class="box-body">
    <div class="sinc-form">

        <?php $form = ActiveForm::begin(['action' => [Url::to('sincroniza')]]); ?>

        <div class="form-group">
            <?= Html::submitButton('Atualiza Dados', ['class' => 'btn btn-info', 'name' => 'but', 'value' => 'atualiza_dados']) ?>
            <?= Html::submitButton('Recalcula Compra Ativos', ['class' => 'btn btn-info', 'name' => 'but', 'value' => 'recalcula_ativos']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
Modal::begin([
    'title'        => '<h5 class = "card-title" id="progress"></h5>',
    'id'            => 'progress-modal',
    'closeButton'   => false,
    'clientOptions' => ['backdrop' => 'static', 'keyboard' => false]
]);
?>

<?=
Progress::widget([
    'percent' => 0,
    'options' => ['class' => 'progress-success active progress-striped']
]);
?>

<?php Modal::end(); ?>