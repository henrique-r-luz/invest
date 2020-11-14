<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\BalancoEmpresaBolsaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="balanco-empresa-bolsa-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'patrimonio_liquido') ?>

    <?= $form->field($model, 'receita_liquida') ?>

    <?= $form->field($model, 'ebitda') ?>

    <?php // echo $form->field($model, 'da') ?>

    <?php // echo $form->field($model, 'ebit') ?>

    <?php // echo $form->field($model, 'margem_ebit') ?>

    <?php // echo $form->field($model, 'resultado_financeiro') ?>

    <?php // echo $form->field($model, 'imposto') ?>

    <?php // echo $form->field($model, 'lucro_liquido') ?>

    <?php // echo $form->field($model, 'margem_liquida') ?>

    <?php // echo $form->field($model, 'roe') ?>

    <?php // echo $form->field($model, 'caixa') ?>

    <?php // echo $form->field($model, 'divida_bruta') ?>

    <?php // echo $form->field($model, 'divida_liquida') ?>

    <?php // echo $form->field($model, 'divida_bruta_patrimonio') ?>

    <?php // echo $form->field($model, 'divida_liquida_ebitda') ?>

    <?php // echo $form->field($model, 'fco') ?>

    <?php // echo $form->field($model, 'capex') ?>

    <?php // echo $form->field($model, 'fcf') ?>

    <?php // echo $form->field($model, 'fcl') ?>

    <?php // echo $form->field($model, 'fcl_capex') ?>

    <?php // echo $form->field($model, 'proventos') ?>

    <?php // echo $form->field($model, 'payout') ?>

    <?php // echo $form->field($model, 'pdd') ?>

    <?php // echo $form->field($model, 'pdd_lucro_liquido') ?>

    <?php // echo $form->field($model, 'indice_basileia') ?>

    <?php // echo $form->field($model, 'codigo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
