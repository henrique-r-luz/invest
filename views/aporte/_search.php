<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\widgets\Select2;
use app\models\Ativo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TipoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-search">
    <div class="box-success box">
        <div class="box-body">
            <div class="ativo-form">

                <?php
                $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'post',
                ]);
                ?>
                <div class="col-xs-12 col-lg-12 no-padding">
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                        <?=
                        $form->field($model, 'valor')->widget(NumberControl::classname(), [
                            'maskedInputOptions' => [
                                'allowMinus' => false,
                                'rightAlign' => false
                            ],
                        ])
                        ?>
                    </div>   
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                        <?=
                        $form->field($model, 'ativo')->widget(Select2::classname(), [
                            'data' => ArrayHelper::map(Ativo::find()->where(['tipo' => \app\lib\Tipo::ACOES])->asArray()->all(), 'id', 'codigo'),
                            'options' => ['placeholder' => 'Selecione um Tipo'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                            'options' => [
                                'multiple' => true,
                            ],
                        ]);
                        ?>

                    </div>

                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <?= Html::submitButton('Distribuir', ['class' => 'btn btn-primary']) ?>
                         <?= Html::a('<i class="glyphicon glyphicon-erase"></i> Reset', ['index'], ['class' => 'btn btn-default']) ?>    
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
