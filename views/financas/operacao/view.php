<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\financas\Operacao;

/* @var $this yii\web\View */
/* @var $model app\models\Operacao */

$this->title = 'Visualiza ' . 'Operacao';
$this->params['breadcrumbs'][] = ['label' => 'Operacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-info card card-outline">
    <div class="card-body">
        <div class="operacao-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'condensed' => true,
                'notSetIfEmpty' => true,
                'attributes' => [
                    [
                        'columns' => [
                            [
                                'label' => 'Id',
                                'value' => $model->id,
                                'labelColOptions' => ['style' => 'width:3%'],
                            ],
                            [
                                'label' => 'Tipo Operações',
                                'value' =>  Operacao::getTipoOperacao($model->tipo),
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'format' => ['decimal', 2],
                                'Label' => 'Quantidade',
                                'attribute' => 'quantidade',
                                'value' => $model->quantidade
                            ],
                            [
                                'Label' => 'Data',
                                'format' => 'datetime',
                                'attribute' => 'data',
                                'value' => $model->data
                            ]
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Item Ativo Id',
                                'value' => $model->itensAtivo->id,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Ativo Id',
                                'value' => $model->itensAtivo->ativo_id,
                                'labelColOptions' => ['style' => 'width:8%'],
                            ],
                            [
                                'label' => 'Código Ativo',
                                'value' => $model->itensAtivo->ativos->codigo,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Nome Ativo',
                                'value' => $model->itensAtivo->ativos->nome,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ]

                        ],

                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Tipo do Ativo',
                                'value' => $model->itensAtivo->ativos->tipo,
                                'labelColOptions' => ['style' => 'width:12%'],
                            ],
                            [
                                'label' => 'Categória do Ativo',
                                'value' => $model->itensAtivo->ativos->categoria,
                                'labelColOptions' => ['style' => 'width:12%'],
                            ],
                            [
                                'label' => 'Pais',
                                'value' => $model->itensAtivo->ativos->pais,
                                'labelColOptions' => ['style' => 'width:8%'],
                            ],


                        ],

                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Investidor',
                                'value' => $model->itensAtivo->investidor->nome,
                                'labelColOptions' => ['style' => 'width:8%'],
                            ],
                            [
                                'label' => 'Classe Cálculo Ativo',
                                'value' => $model->itensAtivo->ativos->classesOperacoes->nome,
                                'labelColOptions' => ['style' => 'width:15%'],
                            ],



                        ],

                    ],

                ],
            ]) ?>

        </div>
    </div>
</div>