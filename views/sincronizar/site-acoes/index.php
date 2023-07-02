<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atualiza Acões';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-acao-index">



    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => 'padraoCajui',
        'boxTitle' => $this->title,
        'columns' => [
            [
                'label' => 'Ativo Id',
                'attribute' => 'ativo_id',
                'value' => function ($model) {
                    return $model->ativo->id;
                },
            ],
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_nome',
                'value' => 'ativo.codigo'
            ],

            'url:ntext',
            ['class' => 'app\lib\grid\ActionColumn'],
        ],

    ]);
    ?>


</div>