<?php

use app\models\Ativo;
use app\models\CotacaoAtivo;
use kartik\number\NumberControl;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model CotacaoAtivo */
/* @var $form ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="cotacao-ativo-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-4 col-sm-4 col-lg-4">
        
                    <?= $form->field($model, 'nome')->textInput() ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                 <?=$form->field($model, 'ativo_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Ativo::find()->where(['tipo'=> \app\lib\Tipo::ACOES])->asArray()->all(), 'id', 'codigo'),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                 <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?= $form->field($model, 'valor')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                    ]) ?>         
                    
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
