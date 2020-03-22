<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Notificacao */

$this->title = 'Visualiza '. 'Notificacao';
$this->params['breadcrumbs'][] = ['label' => 'Notificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="box box-default">
        <div class="box-header with-border">
<div class="notificacao-view">
    
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
            'user_id',
            'dados',
            'lido:boolean',
            'created_at',
            'updated_at',
            ],
            ]) ?>

        </div>
    </div>
</div>
