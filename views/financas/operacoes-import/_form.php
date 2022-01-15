<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\file\FileInput;
use app\lib\TipoArquivoUpload;
use app\models\financas\Investidor;

/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImport */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="operacoes-import-form">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <?=
                $form->field($model, 'investidor_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(app\models\financas\Investidor::find()->asArray()->all(), 'id', 'nome'),
                    'options' => ['placeholder' => 'Selecione um Investidor'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-lg-6">
                <?=
                $form->field($model, 'tipo_arquivo')->widget(Select2::classname(), [
                    'data' => TipoArquivoUpload::all(),
                    'options' => ['placeholder' => 'Selecione um Investidor'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
                ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12">
                <?= $form->field($model, 'arquivo')->widget(FileInput::classname(), [
                ]);
  ?>
            </div>

            <div class="col-xs-12 col-sm-12 col-lg-12">
                <div class="form-group">
                    <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>