<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\financas\ClassesOperacoes */
/* @var $form kartik\form\ActiveForm */
?>

<div class="card-success card card-outline">
    <div class="classes-operacoes-form">
        <div class="card-body">
            <?php $form = ActiveForm::begin(['id' => 'classesOperacoes']); ?>

            <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="card-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>