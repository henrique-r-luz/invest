<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaOperacoesManualSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atualiza-operacoes-manual-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'valor_bruto_antigo') ?>

    <?= $form->field($model, 'valor_liquido_antigo') ?>

    <?= $form->field($model, 'atualiza_ativo_manual_id') ?>

    <?= $form->field($model, 'data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
