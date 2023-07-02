<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaAtivoManual */

$this->title = 'Visualiza ' . 'AtualizaAtivoManual';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Ativo Manuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card-info card card-outline">
    <div class="card-body">
        <div class="atualiza-ativo-manual-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'model' => $model,
                'condensed' => true,
                'notSetIfEmpty' => true,
                'attributes' => [
                    [
                        'columns' => [
                            'id',
                            [
                                'label' => 'Item Ativo Id',
                                //'attribute' => 'itens_ativo_id',
                                'value' => $model->itensAtivo->id,
                            ],
                            [
                                'label' => 'Investidor',
                                'value' => $model->itensAtivo->investidor->nome,
                            ]

                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Ativo Id',
                                'value' => $model->itensAtivo->ativos->id,
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

                            //'ativo_id'
                        ],

                    ],
                    /* 'id',
                    [
                        'attribute' => 'itens_ativo_id',
                        'value' => $model->itensAtivo->ativos->codigo,
                    ],
                    [
                        'label' => 'Investidor',
                        'value' => $model->itensAtivo->investidor->nome,
                    ],*/
                ],
            ]) ?>

        </div>
    </div>
</div>