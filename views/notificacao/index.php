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
            'user_id',
           // 'dados',
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
