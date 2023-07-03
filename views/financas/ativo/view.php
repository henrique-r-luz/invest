<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Ativo */

$this->title = 'Visualiza ' . 'Ativo';
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
                            'id',
                            'nome',
                            'codigo'

                        ],
                    ],
                    [
                        'columns' => [
                            'tipo',
                            'categoria',
                            'pais'

                        ],
                    ],
                    [
                        'columns' => [
                            [
                                'label' => 'Classe Cálculo Ativo',
                                'value' => $model->classesOperacoes->nome
                            ]


                        ],
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>