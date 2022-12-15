<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use app\models\financas\Ativo;
use kartik\number\NumberControl;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\Preco */
/* @var $form kartik\form\ActiveForm */
?>

<div class="card-success card card-outline">
    <div class="preco-form">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-lg-6">
                    <?= $form->field($model, 'ativo_id')->widget(Select2::classname(), [
                        'data' => Ativo::listaAtivo(),
                        'options' => ['placeholder' => 'Selecione um Investidor'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                <div class="col-xs-3 col-sm-3 col-lg-3">
                    <?= $form->field($model, 'valor')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                    ]) ?>
                </div>
                <div class="col-xs-3 col-sm-3 col-lg-3">
                    <?= $form->field($model, 'data')->widget(DateControl::class, [
                        'widgetOptions' => [
                            'options' => [
                                'placeholder' => 'data operação'
                            ]
                        ],
                        'type' => DateControl::FORMAT_DATETIME
                    ]) ?>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
</div>