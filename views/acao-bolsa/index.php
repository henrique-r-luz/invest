<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AcaoBolsaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Acao Bolsas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acao-bolsa-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'cnpj',
            'codigo',
            'nome:ntext',
            'setor:ntext',

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
