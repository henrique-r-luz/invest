<?php

use app\models\TipoSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $this View */
/* @var $searchModel TipoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Filtro Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-index">
    <?= $this->render('_search', ['model' => $model]) ?> 
  
        <?php Pjax::begin() ?>
        
        <?=
        GridView::widget([
            'dataProvider' => $provaider,
            'filterModel' => $searchModel,
          //  'pjax'=>true,
            'columns' => [
                'cnpj',
                'codigo',
                'nome',
                'setor',
            ],
            'panel' => [
                'type' => GridView::TYPE_DEFAULT,
            //'heading' => false,
            ],
            'toolbar' => [
                '{export}',
            ],
        ]);
        ?>
        <?php Pjax::end() ?>
   
</div>
