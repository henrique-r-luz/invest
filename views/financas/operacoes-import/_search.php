<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImportSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operacoes-import-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'investidor_id') ?>

    <?= $form->field($model, 'arquivo') ?>

    <?= $form->field($model, 'tipo_arquivo') ?>

    <?= $form->field($model, 'lista_operacoes_criadas_json') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
