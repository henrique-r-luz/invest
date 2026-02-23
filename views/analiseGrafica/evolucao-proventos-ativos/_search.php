<?php


use app\models\financas\ItensAtivo;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;


/* @var $this View */
/* @var $matriculaDisciplinaForm MatriculaDisciplinaForm */

?>

<div class="card-default card card-outline card-success">
    <div class="matricula-search">
        <div class="card-body">
            <?php
            $form = ActiveForm::begin([
                'id' => 'form-evelicao-proventos-ativos',
                'action' => ['index'],
                'method' => 'get',
            ])
            ?>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-lg-12">
                    <?=
                    $form->field($itensAtivo, 'id')->widget(Select2::classname(), [
                        'data' => ItensAtivo::lista(),
                        'options' => [
                            'placeholder' => 'Selecione um Item Ativo',
                            'id' => 'item_ativo',
                        ],

                        'pluginOptions' => [
                            'allowClear' => true

                        ]
                    ])->label('Item Ativo');
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