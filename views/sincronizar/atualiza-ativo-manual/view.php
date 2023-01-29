<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete this item?',
                        'method' => 'post',
                    ],
                ]) ?>
                <?= Html::a('Voltar', ['index'], ['class' => 'btn btn-default']) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'itens_ativo_id',
                        'value' => $model->itensAtivo->ativos->codigo,
                    ],
                    [
                        'label' => 'Investidor',
                        'value' => $model->itensAtivo->investidor->nome,
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>