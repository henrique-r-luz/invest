<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histograma';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="index">


    <div class = "search">

        <?php
        $form = ActiveForm::begin([
                    'action' => ['/relatorio/relatorio-aporte'],
                    'method' => 'post',
        ]);
        ?>
        <div class="box-success box">
            <div class="box-body">
                <div class="col-xs-12 col-lg-12 no-padding">
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                        <?=
                         $form->field($model, 'atributo')->textInput() 
                        ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                         <?=
                         $form->field($model, 'numeroClasse')->textInput() 
                        ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                         <?=
                         $form->field($model, 'empresas')->textInput() 
                        ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                         <?=
                         $form->field($model, 'tempo')->textInput() 
                        ?>
                    </div>
                    <div class="col-xs-12 col-lg-12 ">
                        <div class="form-group">
                            <?= Html::submitButton('Gráfico', ['class' => 'btn btn-primary']) ?>
                             <?= Html::a('Limpar', ['/relatorio/relatorio-aporte'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <?php ActiveForm::end(); ?>

    </div>
</div>    


