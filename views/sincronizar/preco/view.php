<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\Preco */

$this->title = 'Visualiza '. 'Preco';
$this->params['breadcrumbs'][] = ['label' => 'Precos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="card-info card card-outline">
    <div class="card-body">
        <div class="preco-view">

            <p>
                <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
                ],
                ]) ?>
                <?= Html::a('Voltar',['index'], ['class' => 'btn btn-default']) ?>
            </p>

            <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                        'id',
            'valor',
            'ativo_id',
            ],
            ]) ?>

        </div>
    </div>
</div>