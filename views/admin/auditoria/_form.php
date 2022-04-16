<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\admin\Auditoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
       <div class="auditoria-form">
            <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'model')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'operacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'changes')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

            <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar',['index'], ['class' => 'btn btn-default']) ?>
            </div>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
