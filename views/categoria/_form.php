<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
       <div class="categoria-form">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'nome')->textInput() ?>

            <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar',['index'], ['class' => 'btn btn-default']) ?>
            </div>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
