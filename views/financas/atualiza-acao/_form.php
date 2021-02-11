<?php

use app\models\financas\Ativo;
use app\models\financas\AtualizaAcao;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;
use app\lib\Tipo;

/* @var $this View */
/* @var $model AtualizaAcao */
/* @var $form ActiveForm */
?>

<div class="box-success box">
    <div class="box-body">
        <div class="atualiza-acao-form">
            <?php $form = ActiveForm::begin(); ?>
            <div class="col-xs-12 col-lg-12 no-padding">
                <div class="col-xs-4 col-sm-4 col-lg-4">
                    <?=
                    $form->field($model, 'ativo_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(Ativo::find()->where(['tipo'=> Tipo::ACOES])->asArray()->all(), 'id', 'codigo'),
                        'options' => ['placeholder' => 'Selecione um Tipo'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
                <div class="col-xs-8 col-sm-8 col-lg-8">
                    <?= $form->field($model, 'url')->textInput() ?>
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
