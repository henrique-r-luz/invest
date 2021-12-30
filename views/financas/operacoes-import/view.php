<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImport */

$this->title = 'Visualiza '. 'OperacoesImport';
$this->params['breadcrumbs'][] = ['label' => 'Operacoes Imports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="box box-default">
        <div class="box-header with-border">
<div class="operacoes-import-view">
    
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
            'investidor_id',
            'arquivo:ntext',
            'tipo_arquivo:ntext',
            'lista_operacoes_criadas_json:ntext',
            ],
            ]) ?>

        </div>
    </div>
</div>
