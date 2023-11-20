<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sincronizar\XpthBotSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Xpath Bots';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xpath-bot-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
                'toolbar' => 'padraoCajui',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'boxTitle' => $this->title,
                'columns' => [
                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:7%;'],
                        ],
                        [
                                'attribute' => 'ativo',
                                'options' => ['style' => 'width:10%;'],
                        ],
                        'xpath:ntext',
                        [
                                'attribute' => 'data',
                                'format' => ['date', 'php: d/m/Y'],
                                'options' => ['style' => 'width:10%;'],
                                //'options' => ['style' => 'width:7%;'],
                        ],

                        //'format' => ['date', 'php: d.m.Y H:i:s']


                        ['class' => 'app\lib\grid\ActionColumn'],
                ],
        ]); ?>


</div>