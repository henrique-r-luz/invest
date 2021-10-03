<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\AcaoBolsa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="acao-bolsa-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 col-lg-12">
                <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?= $form->field($model, 'codigo')->textInput() ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?= $form->field($model, 'setor')->textInput() ?>
                </div>
                <div class="col-xs-4 col-lg-4 col-lg-4">
                    <?= $form->field($model, 'cnpj')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-lg-12 col-lg-12">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>
