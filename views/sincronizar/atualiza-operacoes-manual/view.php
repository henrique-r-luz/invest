<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

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
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'valor_bruto',
                    'valor_liquido',
                    //'atualiza_ativo_manual_id',
                    [
                        'attribute' => 'atualiza_ativo_manual_id',
                        'value' => $model->atualizaAtivoManual->itensAtivo->ativos->codigo,
                    ],
                    [
                        'label' => 'Investidor',
                        'value' => $model->atualizaAtivoManual->itensAtivo->investidor->nome,
                    ],
                    [
                        'attribute' => 'data',
                        'format' => 'dateTime',
                    ],
                ],
            ]) ?>

        </div>
    </div>
</div>