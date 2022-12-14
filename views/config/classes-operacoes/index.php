<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\ClassesOperacoesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Classes Operacoes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-operacoes-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
            <?= GridView::widget([
        'toolbar' => 'padraoCajui',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

                    'id',
            'nome',

        ['class' => 'app\lib\grid\ActionColumn'],
        ],
        ]); ?>
    
    
</div>
