<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\number\NumberControl;
use kartik\datecontrol\DateControl;
use app\models\sincronizar\AtualizaOperacoesManualSearch;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaOperacoesManual */
/* @var $form kartik\form\ActiveForm */
?>

<div class="card-success card card-outline">
    <?php $form = ActiveForm::begin(); ?>
    <div class="atualiza-operacoes-manual-form">
        <div class="card-body">

            <div class='row'>
                <div class="col-xs-12 col-sm-8 col-lg-8">
                    <?=
                    $form->field($model, 'atualiza_ativo_manual_id')->widget(Select2::classname(), [
                        'data' => AtualizaOperacoesManualSearch::lista(),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-lg-4">
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
            <div class='row'>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <?= $form->field($model, 'valor_bruto')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                    ]) ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <?= $form->field($model, 'valor_liquido')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>