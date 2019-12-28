<?php

use yii\helpers\Html;
use \kartik\grid\GridView;
use \app\models\Operacao;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Aportes por tempo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacao-index">


    <div class = "operacao-search">

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
                        $form->field($model, 'dataInicio')->widget(DateControl::class, [
                            'widgetOptions' => [
                                'options' => [
                                    'placeholder' => 'data inicial'
                                ]
                            ],
                            'type' => DateControl::FORMAT_DATE
                        ])
                        ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-lg-6">
                        <?=
                        $form->field($model, 'dataFim')->widget(DateControl::class, [
                            'widgetOptions' => [
                                'options' => [
                                    'placeholder' => 'data final'
                                ]
                            ],
                            'type' => DateControl::FORMAT_DATE
                        ])
                        ?>
                    </div>
                    <div class="col-xs-12 col-lg-12 ">
                        <div class="form-group">
                            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                             <?= Html::a('Limpar', ['/relatorio/relatorio-aporte'], ['class' => 'btn btn-default']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
        <?php ActiveForm::end(); ?>

    </div>
    <?php if ($model->dataInicio != null): ?>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            #'filterModel' => $searchModel,
            'columns' => [
                'codigo',
                'nome',
                'quantidade',
                [
                    'attribute' => 'total',
                    'format' => 'currency',
                ],
            /* [
              'label' => 'Código',
              'value' => function ($model) {
              return
              }
              ],
              [
              'label' => 'Nome',
              ], */
            ],
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
            //'heading' => true,
            ],
        ]);
        ?>

    <?php endif; ?>
</div>
