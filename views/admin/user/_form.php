<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\widgets\Select2;
use app\lib\helpers\user\GruposUser;

/* @var $this yii\web\View */
/* @var $model app\models\admin\User */
/* @var $form kartik\form\ActiveForm */
?>

<div class="card-success card card-outline">
    <?php $form = ActiveForm::begin(['id' => "form_user"]); ?>
    <div class="user-form">
        <div class="card-body">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'grupo')->widget(Select2::classname(), [
                'data' => GruposUser::listaGrupos(),
                'options' => ['placeholder' => 'Selecione um Investidor'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $form->field($model, 'password')->passwordInput(['autocomplete' => "new-password"])  ?>
            <?= $form->field($model, 'confirma')->passwordInput()  ?>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>