<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\AcaoBolsa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= $model->isNewRecord ? 'card-success' : 'card-info' ?> card card-outline">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
        <div class="acao-bolsa-form">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <?= $form->field($model, 'nome')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
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
    </div>
    <div class="card-footer">
        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>

</div>
<?php ActiveForm::end(); ?>
</div>