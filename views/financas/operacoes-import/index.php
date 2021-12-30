<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacoesImportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operacoes Imports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacoes-import-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

                    'id',
            'investidor_id',
            'tipo_arquivo:ntext',

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
