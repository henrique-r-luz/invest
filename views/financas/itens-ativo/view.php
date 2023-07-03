<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Ativo */

$this->title = 'Visualiza ' . 'Iten Ativo';
$this->params['breadcrumbs'][] = ['label' => 'Ativos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card-info card card-outline">
    <div class="card-body">
        <div class="ativo-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'condensed' => true,
                'notSetIfEmpty' => true,
                'attributes' => [
                    [
                        'columns' => [
                            [
                                'label' => 'Iten Ativo Id',
                                'labelColOptions' => ['style' => 'width:10%'],
                                'value' => $model->id,
                            ],
                            [
                                'label' => 'Ativo Id',
                                'labelColOptions' => ['style' => 'width:10%'],
                                'value' => $model->ativo_id,
                            ],
                            [
                                'label' => 'Código Ativo',
                                'value' => $model->ativos->codigo,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Nome Ativo',
                                'value' => $model->ativos->nome,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ]

                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'format' => ['decimal', 2],
                                'attribute' => 'quantidade',
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'format' => ['decimal', 2],
                                'attribute' => 'valor_compra',
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'format' => ['decimal', 2],
                                'attribute' => 'valor_bruto',
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'format' => ['decimal', 2],
                                'attribute' => 'valor_liquido',
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Investidor',
                                'value' => $model->investidor->nome,
                                'labelColOptions' => ['style' => 'width:8%'],
                            ],
                            [
                                'label' => 'Tipo',
                                'value' => $model->ativos->tipo,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Categoria',
                                'value' => $model->ativos->categoria,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Pais',
                                'value' => $model->ativos->pais,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                        ],
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>