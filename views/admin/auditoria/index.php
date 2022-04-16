<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\admin\AuditoriaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Auditorias';
$this->params['breadcrumbs'][] = $this->title;
$botaoRedo = Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Limpar Filtros', 'data-pjax' => 0]);
?>
<div class="auditoria-index">

        <?= GridView::widget([
                'toolbar' => [
                        'content' => '<div class="btn-group">' . $botaoRedo . '</div>',
                        '{toggleData}',
                        '{export}',
                ],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [

                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:5%;']
                        ],
                        'model:ntext',
                        'operacao:ntext',
                        //'changes',
                        [
                                'format'=>'raw',
                                'attribute' => 'changes',
                                'value' => function ($model) {
                                        //return json_encode($model->changes,'JSON_PRETTY_PRINT','JSON_UNESCAPED_UNICODE');
                                        return json_encode($model->changes,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
                                },
                                'options' => ['style' => 'width:45%;']
                        ],
                        [
                                'attribute' => 'user_id',
                                'value' => function ($model) {
                                        return $model->user->username;
                                },
                        ],
                        [
                                'attribute' => 'created_at',
                                'value' =>function($model){
                                        return date('d/m/y H:i:s', $model->created_at);      
                                } ,
                        ],
                        // ['class' => 'app\lib\grid\ActionColumn'],
                ],
                'boxTitle' => $this->title,
        ]); ?>


</div>