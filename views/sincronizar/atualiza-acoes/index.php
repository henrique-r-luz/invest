<?php

use app\lib\dicionario\StatusAtualizacaoAcoes;
use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sincronizar\AtualizaAcoesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atualiza Acoes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-acoes-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
                'toolbar' => 'padraoCajui',
                'dataProvider' => $dataProvider,
                'boxTitle' => $this->title,
                'columns' => [
                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:7%;'],

                        ],
                        [
                                'attribute' => 'data',
                                'options' => ['style' => 'width:20%;'],
                                'value' => function ($model) {
                                        $date = date_create($model->data);
                                        return date_format($date, 'd/m/Y H:i:s');
                                },
                        ],
                        [
                                'label' => 'Ativos Atualizados',
                                'options' => ['style' => 'width:30%;'],
                                'format' => 'raw',
                                'value' => function ($model) {
                                        return $model->formataAtivoAtualizados(true);
                                }
                        ],
                        [
                                'label' => 'Ativos Pendentes',
                                'options' => ['style' => 'width:30%;'],
                                'value' => function ($model) {
                                        return $model->formataAtivoAtualizados(false);
                                }
                        ],

                        [
                                'attribute' => 'status',
                                'format' => 'raw',
                                'options' => ['style' => 'width:10%;'],
                                'value' => function ($model) {
                                        $class = "badge bg-default";
                                        if ($model->status == StatusAtualizacaoAcoes::PROCESSANDO) {
                                                $class = "badge bg-warning";
                                        }

                                        if ($model->status == StatusAtualizacaoAcoes::FINALIZADO) {
                                                $class = "badge bg-success";
                                        }


                                        return '<span class="' . $class . '" style="font-size:90%">' . $model->status . '</span>';
                                }

                        ],
                ],
        ]); ?>


</div>