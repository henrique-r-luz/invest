<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

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
        'toolbar'=>'padraoCajui',
        'columns' => [
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_id',
                'value' => 'ativo.codigo'
            ],
            'url:ntext',
            ['class' => 'app\lib\grid\ActionColumn'],
        ],
        
    ]);
    ?>


</div>