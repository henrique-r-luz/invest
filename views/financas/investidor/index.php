<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\InvestidorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Investidors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="investidor-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar'=>'padraoCajui',
        'boxTitle' => $this->title,
        'columns' => [
            'id',
            'cpf',
            'nome:ntext',
            ['class' => 'app\lib\grid\ActionColumn'],
        ],
    ]);
    ?>


</div>
