<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
                'attributes' => [
                    'id',
                    'tipo:ntext',
                    'quantidade',
                    'valor',
                    'data',
                    'ativo_id',
                ],
            ]) ?>

        </div>
    </div>
</div>