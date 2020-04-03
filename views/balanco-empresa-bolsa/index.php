<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BalancoEmpresaBolsaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Balancos das Empresas da Bolsa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balanco-empresa-bolsa-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

             //       'id',
            'data',
            'codigo',
            'patrimonio_liquido',
            'receita_liquida',
            'ebitda',
            //'da',
            //'ebit',
            //'margem_ebit',
            'resultado_financeiro',
            //'imposto',
            //'lucro_liquido',
            //'margem_liquida',
            //'roe',
            //'caixa',
            //'divida_bruta',
            //'divida_liquida',
            //'divida_bruta_patrimonio',
            //'divida_liquida_ebitda',
            //'fco',
            //'capex',
            //'fcf',
            //'fcl',
            //'fcl_capex',
            //'proventos',
            //'payout',
            //'pdd',
            //'pdd_lucro_liquido',
            //'indice_basileia',
            //'codigo',

        ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
        'type' => GridView::TYPE_DEFAULT,
        //'heading' => true,
        ],
        'toolbar' => [
        [
        'content' =>Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar'])
        ],
        '{toggleData}',
        ],
        ]); ?>
    
    
</div>
