<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CotacaoAtivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cotacão Ativos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotacao-ativo-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

                    'id',
            ['attribute'=>'ativo_id',
              'value'=>function($model){
                 if(empty($model->ativo_id)){
                     return $model->nome;
                 }else{
                     return $model->ativo->codigo;
                 }
              },
            ],
            ['attribute'=>'valor',
             'format' => 'currency',
             ],

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
