<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
/* @var $this yii\web\View */
/* @var $model app\models\financas\Investidor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="investidor-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 no-padding">
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
                </div>
            </div>   
            <div class="form-group col-xs-12 col-lg-12">
<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
            </div>

<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
