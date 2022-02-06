<?php

use yii\helpers\Html;
use app\lib\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacoesImportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operacões Imports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacoes-import-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'toolbar' => 'padraoCajui',
                'boxTitle' => $this->title,
                'columns' => [

                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:7%;']
                        ],
                        [
                                'attribute' => 'investidor_id',
                                'value' => 'investidor.nome'

                        ],
                        [
                                'attribute' => 'arquivo'
                        ],
                        'tipo_arquivo:ntext',
                        [
                                'label' => 'Operações criadas',
                                'attribute' => 'lista_operacoes_criadas_json',
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