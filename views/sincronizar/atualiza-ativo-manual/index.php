<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sincronizar\AtualizaAtivoManualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atualiza Ativo Manual';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-ativo-manual-index">
        <?= GridView::widget([
                'toolbar' => 'padraoCajui',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'boxTitle' => $this->title,
                'columns' => [

                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:5%;'],
                        ],
                        [
                                'attribute' => 'itens_ativo_id',
                                'value' => function ($model) {
                                        return $model->itensAtivo->id . ' - ' . $model->itensAtivo->ativos->codigo;
                                }
                        ],

                        [
                                'attribute' => 'investidor',
                                'value' => function ($model) {
                                        return  $model->itensAtivo->investidor->nome;
                                }
                        ],

                        ['class' => 'app\lib\grid\ActionColumn'],
                ],
        ]); ?>


</div>