<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="operacoes-import-form">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

            <?= $form->field($model, 'investidor_id')->textInput() ?>
            <?= $form->field($model, 'tipo_arquivo')->textarea(['rows' => 6]) ?>

            <?= $form->field($model, 'arquivo')->fileInput() ?>



            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>