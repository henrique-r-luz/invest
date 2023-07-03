<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\lib\dicionario\ProventosMovimentacao;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Proventos */

$this->title = 'Visualiza ' . 'Proventos';
$this->params['breadcrumbs'][] = ['label' => 'Proventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card-info card card-outline">
    <div class="card-body">
        <div class="proventos-view">

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
                                'label' => 'Item Ativo Id',
                                'value' => $model->itensAtivo->id,
                                'labelColOptions' => ['style' => 'width:12%'],
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
                                'label' => 'Movimentação',
                                'value' =>  ProventosMovimentacao::getNome($model->movimentacao),
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'format' => ['decimal', 2],
                                'label' => 'Valor',
                                'value' => $model->valor,
                                'labelColOptions' => ['style' => 'width:8%'],
                            ],
                            [
                                'Label' => 'Data',
                                'format' => 'datetime',
                                'attribute' => 'data',
                                'value' => $model->data
                            ],
                            [
                                'label' => 'Pais',
                                'value' => $model->itensAtivo->ativos->pais,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ]

                        ],

                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>