<?php


use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\financas\Investidor;


/* @var $this View */
/* @var $matriculaDisciplinaForm MatriculaDisciplinaForm */

?>

<div class="card-default card card-outline card-success">
    <div class="matricula-search">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'form-bens-direitos',
                'action' => ['index'],
                'method' => 'get',
            ])
            ?>

            <div class="row">
                <div class="col-12 col-sm-6 col-lg-6">
                    <?= $form->field($formBensDireitos, 'ano')->textInput() ?>
                </div>

                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <?=
                    $form->field($formBensDireitos, 'investidor_id')->widget(Select2::classname(), [
                        'data' => ArrayHelper::map(app\models\financas\Investidor::find()->asArray()->all(), 'id', 'nome'),
                        'options' => ['placeholder' => 'Selecione um Investidor'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?= Html::submitButton('<i class="fas fa-search"></i> Buscar', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('<i class="fas fa-eraser"></i> Limpar', ['index'], ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>