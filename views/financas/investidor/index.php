<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\InvestidorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Investidors';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="investidor-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

                    'id',
            'cpf',
            'nome:ntext',

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
