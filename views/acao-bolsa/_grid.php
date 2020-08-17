<?php

use app\models\AcaoBolsaSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

//use kartik\icons\Icon;
// Maps the Elusive icon font framework
//Icon::map($this);  
/* @var $this View */
/* @var $searchModel AcaoBolsaSearch */
/* @var $dataProvider ActiveDataProvider */
?>




<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:10px;'],
    'columns' => [
        [
            'attribute' =>'data',
        ],
        [
        'attribute' => 'patrimonio_liquido',
            ],
        'receita_liquida',
        'ebitda',
        'da',
        'ebit',
        'resultado_financeiro',
        'imposto',
        'margem_ebit',
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
    ],
    'toolbar' => null,
    'summary' => false,
    'floatHeader' => false,
]);
?>



