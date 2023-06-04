<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sincronizar\PrecoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Preços';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preco-index">

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
                                'attribute' => 'ativo_id',
                                'value' => function ($model) {
                                        return $model->ativo->nome;
                                },
                        ],
                        [
                                'attribute' => 'valor',
                                'format' => 'currency',
                                'value' => function ($model) {
                                        return $model->valor;
                                },
                        ],
                        [
                                'attribute' => 'atualiza_acoes_id',
                                'value' => function ($model) {
                                        return $model->atualiza_acoes_id ?? '';
                                },
                        ],
                        [
                                'attribute' => 'data',
                                'value' => function ($model) {
                                        $date = date_create($model->data);
                                        return date_format($date, 'd/m/Y H:i:s');
                                },
                        ],

                        ['class' => 'app\lib\grid\ActionColumn'],
                ],
        ]); ?>


</div>