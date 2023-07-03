<?php

use yii\web\View;
use yii\helpers\Html;
use kartik\widgets\Select2;
use app\lib\helpers\TipoMoeda;
use kartik\widgets\ActiveForm;
use kartik\number\NumberControl;
use app\models\financas\ItensAtivo;
use kartik\datecontrol\DateControl;
use app\lib\dicionario\ProventosMovimentacao;

/* @var $this View */
/* @var $model Proventos */
/* @var $form ActiveForm */

$valor = 'Valor';
$valor = TipoMoeda::valor($model->itensAtivo->ativos->pais, $valor);
?>
<div class="<?= $model->isNewRecord ? 'card-success' : 'card-info' ?> card card-outline">
    <?php $form = ActiveForm::begin(['id' => 'form_proventos']); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6">
                <?=
                $form->field($model, 'itens_ativos_id')->widget(Select2::classname(), [
                    'data' => ItensAtivo::lista(), //ArrayHelper::map(Ativo::find()->andWhere(['categoria'=> app\lib\Categoria::RENDA_VARIAVEL])->asArray()->all(), 'id', 'codigo'),
                    'options' => [
                        'placeholder' => 'Selecione um Item Ativo',
                        'id' => 'item_ativo',
                    ],

                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                    'pluginEvents' => [
                        "change" => 'function(data) { 
                            tipoMoeda.setMoeda();
                        }',
                    ]
                ]);
                ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-6">
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
        </div>
        <div class='row'>
            <div class="col-xs-6 col-sm-6 col-lg-6">
                <?=
                $form->field($model, 'valor')->widget(NumberControl::classname(), [
                    'maskedInputOptions' => [
                        'allowMinus' => false
                    ],
                ])->label($valor, ['id' => 'valor'])
                ?>
            </div>
            <div class="col-xs-6 col-sm-6 col-lg-6">
                <?=
                $form->field($model, 'movimentacao')->widget(Select2::classname(), [
                    'data' => ProventosMovimentacao::all(), //ArrayHelper::map(Ativo::find()->andWhere(['categoria'=> app\lib\Categoria::RENDA_VARIAVEL])->asArray()->all(), 'id', 'codigo'),
                    'options' => ['placeholder' => 'Selecione um Tipo'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
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