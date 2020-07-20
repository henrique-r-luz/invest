<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Filtro Empresas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipo-index">
    <?= $this->render('_search', ['model' => $model]) ?> 

    <?php if (isset($model->id)): ?>
        <?=
        GridView::widget([
            'dataProvider' => $provaider,
            //'filterModel' => $searchModel,
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
    <?php endif; ?>
</div>
