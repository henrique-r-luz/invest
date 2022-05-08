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
    <div class="user-form">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>

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
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>