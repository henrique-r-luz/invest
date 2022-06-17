<?php

use app\lib\grid\GridView;


/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preço';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preco-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);    
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
        'toolbar' => 'precoCajui',
        'boxTitle' => $this->title,

        'columns' => [
            'codigo',
            'valor'
        ],
    ]);
    ?>


</div>