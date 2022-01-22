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
use kartik\widgets\ActiveForm;

/* @var $this View */
/* @var $model Proventos */
/* @var $form ActiveForm */
?>
<div class="<?= $model->isNewRecord ? 'card-success' : 'card-info' ?> card card-outline">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-4 col-sm-4 col-lg-4">
                <?=
                $form->field($model, 'itens_ativos_id')->widget(Select2::classname(), [
                    'data' => ItensAtivo::lista(), //ArrayHelper::map(Ativo::find()->andWhere(['categoria'=> app\lib\Categoria::RENDA_VARIAVEL])->asArray()->all(), 'id', 'codigo'),
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
                    'type' => DateControl::FORMAT_DATETIME
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
    </div>
        <div class="card-footer">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    <?php ActiveForm::end(); ?>
</div>