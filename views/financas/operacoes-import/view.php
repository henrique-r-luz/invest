<?php

use yii\helpers\Html;
use kartik\detail\DetailView;


/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImport */

$this->title = 'Visualiza ' . 'Operacoes Imports';
$this->params['breadcrumbs'][] = ['label' => 'Operacoes Imports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-info card card-outline">
    <div class="card-body">
        <div class="operacoes-import-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
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
                                'label' => 'Investidor',
                                'value' => $model->investidor->nome,
                                'labelColOptions' => ['style' => 'width:8%'],
                            ],
                            [
                                'label' => 'Arquivo',
                                'value' => $model->arquivo,
                                'labelColOptions' => ['style' => 'width:8%'],
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
                                'label' => 'Tipo',
                                'value' => $model->tipo_arquivo,
                                'labelColOptions' => ['style' => 'width:5%'],
                            ],

                            [
                                'Label' => 'Operações Criadas',
                                'attribute' => 'lista_operacoes_criadas_json',
                                'value' => $model->lista_operacoes_criadas_json
                            ]
                        ],
                    ],

                ],
            ]) ?>

        </div>
    </div>
</div>