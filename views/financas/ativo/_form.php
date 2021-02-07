<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\SwitchInput;
use kartik\widgets\Select2;
use app\models\Categoria;
use yii\helpers\ArrayHelper;
use app\models\Tipo;
use app\lib\Pais;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Ativo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="ativo-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <?= $form->field($model, 'nome')->textInput() ?>
                </div> 
            </div>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?= $form->field($model, 'codigo')->textInput() ?>
                </div>
                 <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?=
                    $form->field($model, 'acao_bolsa_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\financas\AcaoBolsa::find()->asArray()->all(), 'id', 'codigo'),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                 <div class="col-xs-2 col-sm-2 col-lg-2">
                    <?=  $form->field($model, 'pais')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(Tipo::find()->asArray()->all(), 'id', 'nome'),
                        'data' => \app\lib\Pais::all(),
                        'options' => ['placeholder' => 'País'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
                  <div class="col-xs-2 col-sm-2 col-lg-2">
                    <?=
                    $form->field($model, 'ativo')->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'onText' => 'Sim',
                            'offText' => 'Não',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                        ]
                    ])
                    ?>
                </div>
            </div>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-2 col-sm-2 col-lg-2">
                    <?=
                    $form->field($model, 'valor_liquido')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                        'readonly' => true,//($model->isNewRecord) ? true : false,
                    ])
                    ?>
                </div>
                <div class="col-xs-2 col-sm-2 col-lg-2">
                    <?=
                    $form->field($model, 'valor_bruto')->widget(NumberControl::classname(), [
                        'maskedInputOptions' => [
                            'allowMinus' => false
                        ],
                        'readonly' => true,//($model->isNewRecord) ? true : false,
                    ])
                    ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?=
                    $form->field($model, 'tipo')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(Tipo::find()->asArray()->all(), 'id', 'nome'),
                        'data' => \app\lib\Tipo::all(),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?=
                    $form->field($model, 'categoria')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(Categoria::find()->asArray()->all(), 'id', 'nome'),
                        'data' => app\lib\Categoria::all(),
                        'options' => ['placeholder' => 'Selecione a Categoria'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
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
