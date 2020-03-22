<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NotificacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Notificacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notificacao-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
            'attribute'=>'user_id',
             'value'=>function($model){
                if($model->user_id==1){
                    return 'Sistema';
                }
             }   
            ],
           [
               'attribute'=>'dados',
               'format' => 'html',
               'value'=>function($model){
                return implode(",<br/>", $model->dados);
               } 
               ],
            'lido:boolean',
            'created_at',
            //'updated_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        //'heading' => true,
        ],
        'toolbar' => [
            '{toggleData}',
        ],
    ]);
    ?>


</div>
