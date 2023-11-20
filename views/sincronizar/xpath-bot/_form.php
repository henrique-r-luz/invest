<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\XpathBot */
/* @var $form kartik\form\ActiveForm */
?>

<div class="card-success card card-outline">
    <?php $form = ActiveForm::begin(); ?>
    <div class="xpath-bot-form">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-5 col-sm-5 col-lg-5">
                    <?= $form->field($model, 'ativos')->widget(Select2::classname(), [
                        'initValueText' => '', // set the initial display text
                        'options' => [
                            'placeholder' => 'Escolha os ativos ...',
                            'multiple' => true
                        ],
                        'theme' => Select2::THEME_KRAJEE,
                        'data' =>  $model->ListaSiteAcoes(),
                        'pluginOptions' => [
                            'allowClear' => true,
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-5 col-sm-5 col-lg-5">
                    <?= $form->field($model, 'xpath')->textInput() ?>
                </div>
                <div class="col-xs-2 col-sm-2 col-lg-2">
                    <?= $form->field($model, 'data')->widget(DateControl::class, [
                        'widgetOptions' => [
                            'options' => [
                                'placeholder' => 'Data'
                            ]
                        ],
                        'type' => DateControl::FORMAT_DATE
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