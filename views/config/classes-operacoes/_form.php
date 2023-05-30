<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\financas\ClassesOperacoes */
/* @var $form kartik\form\ActiveForm */
?>

<div class="card-success card card-outline">
    <?php $form = ActiveForm::begin(['id' => 'form-classesOperacoes']); ?>
    <div class="classes-operacoes-form">
        <div class="card-body">


            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="card-footer">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>