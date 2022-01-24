<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\BalancoEmpresaBolsa */

$this->title = 'Visualiza '. 'BalancoEmpresaBolsa';
$this->params['breadcrumbs'][] = ['label' => 'Balanco Empresa Bolsas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card-info card card-outline">
        <div class="card-body">
<div class="balanco-empresa-bolsa-view">
    
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
            'data:ntext',
            'patrimonio_liquido',
            'receita_liquida',
            'ebitda',
            'da',
            'ebit',
            'margem_ebit',
            'resultado_financeiro',
            'imposto',
            'lucro_liquido',
            'margem_liquida',
            'roe',
            'caixa',
            'divida_bruta',
            'divida_liquida',
            'divida_bruta_patrimonio',
            'divida_liquida_ebitda',
            'fco',
            'capex',
            'fcf',
            'fcl',
            'fcl_capex',
            'proventos',
            'payout',
            'pdd',
            'pdd_lucro_liquido',
            'indice_basileia',
            'codigo',
            'trimestre',    
            ],
            ]) ?>

        </div>
    </div>
</div>
