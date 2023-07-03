<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Investidor */

$this->title = 'Visualiza ' . 'Investidor';
$this->params['breadcrumbs'][] = ['label' => 'Investidors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-info card card-outline">
    <div class="card-body">
        <div class="investidor-view">

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
                            'cpf',
                            'nome:ntext'
                        ],
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>