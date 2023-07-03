<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaOperacoesManual */

$this->title = 'Visualiza ' . 'Atualiza Operações Manuais';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Operações Manuais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card-info card card-outline">
    <div class="card-body">
        <div class="atualiza-operacoes-manual-view">

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
                            'id',
                            [
                                'label' => 'Item Ativo Id',
                                'value' => $model->atualizaAtivoManual->itensAtivo->id,
                            ],
                            [
                                'format' => ['decimal', 2],
                                'attribute' => 'valor_bruto',
                            ],
                            [
                                'format' => ['decimal', 2],
                                'attribute' => 'valor_liquido'
                            ]
                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Ativo Id',
                                'value' => $model->atualizaAtivoManual->itensAtivo->ativo_id,
                            ],
                            [
                                'label' => 'Código Ativo',
                                'value' => $model->atualizaAtivoManual->itensAtivo->ativos->codigo,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Nome Ativo',
                                'value' => $model->atualizaAtivoManual->itensAtivo->ativos->nome,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ]

                        ],

                    ],

                ],
            ]) ?>

        </div>
    </div>
</div>