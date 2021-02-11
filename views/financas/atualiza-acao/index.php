<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\AtualizaAcaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atualiza Acões';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-acao-index">



    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
               'label'=>'Ativo',
                'attribute'=>'ativo_id',
                'value'=>'ativo.codigo'
            ]
,
            'url:ntext',
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        //'heading' => true,
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar'])
            ],
            '{toggleData}',
        ],
    ]);
    ?>


</div>
