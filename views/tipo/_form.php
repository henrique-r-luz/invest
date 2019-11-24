<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipo */
/* @var $form yii\widgets\ActiveForm */
if($model->isNewRecord){
    $this->title = 'Cria tipo do ativo';
}else{
    $this->title = 'Atualiza tipo do ativo'; 
}
?>
<div class="<?= $model->isNewRecord ? 'box-success' : 'box-info'; ?> box">
  <div class="box-body">
    <div class="tipo-form">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'nome')->textInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Voltar', ['index',], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
