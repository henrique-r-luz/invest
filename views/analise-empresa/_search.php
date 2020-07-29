<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\number\NumberControl;
use kartik\widgets\Select2;
use app\models\Ativo;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\TipoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipo-search">
    <div class="box-success box">
        <div class="box-body">
            <div class="ativo-form">

                <?php
                $form = ActiveForm::begin([
                            'action' => ['index'],
                            'method' => 'get',
                ]);
                ?>
                <div class="col-xs-12 col-lg-12 no-padding">
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                         <?=
                    $form->field($model, 'id')->widget(Select2::classname(), [
                        //'data' => ArrayHelper::map(Categoria::find()->asArray()->all(), 'id', 'nome'),
                        'data' => app\lib\TipoFiltro::all(),
                        'options' => ['placeholder' => 'Selecione o Filtro'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
                    ?>
                    </div>   
                    <div class="col-xs-12 col-sm-12 col-lg-12">
                        <?= Html::submitButton('Pesquisar', ['class' => 'btn btn-primary']) ?>
                         <?= Html::a('<i class="glyphicon glyphicon-erase"></i> Reset', ['index'], ['class' => 'btn btn-default']) ?>    
                    </div>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
