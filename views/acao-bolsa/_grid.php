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

        'columns' => [
           'data',
            'patrimonio_liquido',
            'receita_liquida',
            'ebitda',
           
        ],
        
         'toolbar'=>null,
        'summary'=>false,
         'floatHeader' => false,
    ]);
    ?>



