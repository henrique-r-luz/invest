<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tipos de Ativo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-index">

 
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
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
            ]);
            ?>
     

</div>
