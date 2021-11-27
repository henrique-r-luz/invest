<?php

use app\models\financas\Ativo;
use app\models\financas\ItensAtivo;
use app\models\financas\Proventos;
use kartik\datecontrol\DateControl;
use kartik\number\NumberControl;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $model Proventos */
/* @var $form ActiveForm */
?>
<div class="box-success box">
    <div class="box-body">
        <div class="proventos-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?=
                    $form->field($model, 'itens_ativos_id')->widget(Select2::classname(), [
                        'data' => ItensAtivo::lista(),//ArrayHelper::map(Ativo::find()->andWhere(['categoria'=> app\lib\Categoria::RENDA_VARIAVEL])->asArray()->all(), 'id', 'codigo'),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                     <?=
                    $form->field($model, 'data')->widget(DateControl::class, [
                        'widgetOptions' => [
                            'options' => [
                                'placeholder' => 'data operação'
                            ]
                        ],
                        'type'=>DateControl::FORMAT_DATETIME
                    ])
                    ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                     <?=
                    $form->field($model, 'valor')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                    ])
                    ?>
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
