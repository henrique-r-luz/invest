<?php

use yii\web\View;
use yii\helpers\Html;
use kartik\widgets\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\financas\Ativo;
use kartik\number\NumberControl;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use kartik\datecontrol\DateControl;

/* @var $this View */
/* @var $model app\models\Operacao */
/* @var $form ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="operacao-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-8 col-sm-8 col-lg-8">
                    <?=
                    $form->field($model, 'itens_ativos_id')->widget(Select2::classname(), [
                        'data' => ItensAtivo::lista(),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-4 col-lg-4 no-padding">
                    <?=
                    $form->field($model, 'tipo')->widget(Select2::classname(), [
                        'data' => Operacao::tipoOperacao(),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>

                </div>
            </div>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?= 
                        $form->field($model, 'quantidade')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false,
                            'digits' => 15,
                        ],
                    ])
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
