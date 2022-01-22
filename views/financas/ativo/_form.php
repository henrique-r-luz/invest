<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
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

<div class="<?= $model->isNewRecord ? 'card-success' : 'card-info' ?> card card-outline">
<?php $form = ActiveForm::begin(); ?>
    <div class="ativo-form">
        <div class="card-body">
           
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-lg-6">
                    <?= $form->field($model, 'nome')->textInput() ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?= $form->field($model, 'codigo')->textInput() ?>
                </div>
                <div class="col-xs-2 col-sm-2 col-lg-2">
                    <?= $form->field($model, 'pais')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(Tipo::find()->asArray()->all(), 'id', 'nome'),
                        'data' => \app\lib\Pais::all(),
                        'options' => ['placeholder' => 'País'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]); ?>
                </div>
            </div>
            <div class="row">
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
        </div>
        <div class="card-footer">

            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
            
        </div>

    </div>
    <?php ActiveForm::end(); ?>
</div>