<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Notificacao */

$this->title = 'Visualiza ' . 'Notificacao';
$this->params['breadcrumbs'][] = ['label' => 'Notificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="box box-default">
    <div class="box-header with-border">
        <div class="notificacao-view">


            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'columns' => [
                            [
                                'attribute' => 'id',
                                'labelColOptions' => ['style' => 'width: 5%; text-align: right; vertical-align: middle;'],
                                'valueColOptions' => ['style' => 'width:8%'],
                            ],
                            [
                                'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                'valueColOptions' => ['style' => 'width:45%'],
                                'label' => 'Título',
                                'value' => $model->dados['titulo'],
                            ],
                            [
                                'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                'valueColOptions' => ['style' => 'width:45%'],
                                'label' => 'action',
                                'value' => $model->dados['action'],
                            ],
                        /* [
                          'label' =>'Titulo',
                          'value'=>$model->dados['titulo']
                          ], */
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'labelColOptions' => ['style' => 'width: 10%; text-align: right; vertical-align: middle;'],
                                'valueColOptions' => ['style' => 'width:90%'],
                                'label' => 'Mensagem',
                                'value' => $model->dados['mensagem'],
                            ],
                        ],
                    ]
                /* 'id',
                  'user_id', */
                ],
            ])
            ?>

        </div>
    </div>
</div>
