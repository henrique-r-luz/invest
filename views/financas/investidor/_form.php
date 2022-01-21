<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\financas\Investidor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= $model->isNewRecord ? 'card-success' : 'card-info' ?> card card-outline">
    <div class="card-body">
        <div class="investidor-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <?=
                    $form->field($model, 'cpf')->widget(MaskedInput::class, [
                        'mask' => '999.999.999-99',
                        'clientOptions' => ['removeMaskOnSubmit' => true]
                    ])
                    ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <?= $form->field($model, 'nome')->textInput() ?>


                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>
    </div>
    <div class="card-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
</div>