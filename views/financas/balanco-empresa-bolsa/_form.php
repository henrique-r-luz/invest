<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BalancoEmpresaBolsa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body">
        <div class="balanco-empresa-bolsa-form">


            <?= $form->field($model, 'data')->textInput() ?>

            <?= $form->field($model, 'patrimonio_liquido')->textInput() ?>

            <?= $form->field($model, 'receita_liquida')->textInput() ?>

            <?= $form->field($model, 'ebitda')->textInput() ?>

            <?= $form->field($model, 'da')->textInput() ?>

            <?= $form->field($model, 'ebit')->textInput() ?>

            <?= $form->field($model, 'margem_ebit')->textInput() ?>

            <?= $form->field($model, 'resultado_financeiro')->textInput() ?>

            <?= $form->field($model, 'imposto')->textInput() ?>

            <?= $form->field($model, 'lucro_liquido')->textInput() ?>

            <?= $form->field($model, 'margem_liquida')->textInput() ?>

            <?= $form->field($model, 'roe')->textInput() ?>

            <?= $form->field($model, 'caixa')->textInput() ?>

            <?= $form->field($model, 'divida_bruta')->textInput() ?>

            <?= $form->field($model, 'divida_liquida')->textInput() ?>

            <?= $form->field($model, 'divida_bruta_patrimonio')->textInput() ?>

            <?= $form->field($model, 'divida_liquida_ebitda')->textInput() ?>

            <?= $form->field($model, 'fco')->textInput() ?>

            <?= $form->field($model, 'capex')->textInput() ?>

            <?= $form->field($model, 'fcf')->textInput() ?>

            <?= $form->field($model, 'fcl')->textInput() ?>

            <?= $form->field($model, 'fcl_capex')->textInput() ?>

            <?= $form->field($model, 'proventos')->textInput() ?>

            <?= $form->field($model, 'payout')->textInput() ?>

            <?= $form->field($model, 'pdd')->textInput() ?>

            <?= $form->field($model, 'pdd_lucro_liquido')->textInput() ?>

            <?= $form->field($model, 'indice_basileia')->textInput() ?>

            <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
            </div>


        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>