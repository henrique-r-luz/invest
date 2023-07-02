<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\Preco */

$this->title = 'Visualiza ' . 'Preço';
$this->params['breadcrumbs'][] = ['label' => 'Precos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card-info card card-outline">
    <div class="card-body">
        <div class="preco-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
                <?= Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']) ?>
            </p>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'condensed' => true,
                'notSetIfEmpty' => true,
                'attributes' => [
                    [
                        'columns' => [
                            'id',
                            'valor',

                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Ativo Id',
                                'value' => $model->ativo_id,
                            ],
                            [
                                'label' => 'Código Ativo',
                                'value' => $model->ativo->codigo,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ],
                            [
                                'label' => 'Nome Ativo',
                                'value' => $model->ativo->nome,
                                'labelColOptions' => ['style' => 'width:10%'],
                            ]
                        ],

                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>