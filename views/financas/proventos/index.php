<?php

use app\models\financas\Ativo;
use app\models\financas\ProventosSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $searchModel ProventosSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Proventos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proventos-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'label' => 'Ativo Código',
                'attribute' => 'ativo_id',
                'value' => 'ativo.codigo',
            // 'pageSummary' => 'EXTRATO FINANCEIRO',
            // 'pageSummaryOptions' => ['colspan' => 2],
            ],
            'data',
            [
                'attribute' => 'valor',
                'format' => 'currency',
                'value' => function($model) {
                    return Ativo::valorCambio($model->ativo, $model->valor);
                },
                'pageSummary' => function ($summary, $data, $widget)use($dataProvider) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $total = 0;
                    foreach ($objetos as $provento) {
                        $valorCambio = Ativo::valorCambio($provento->ativo, $provento->valor);
                        $total += $valorCambio;
                    }
                    if ($total < 0) {
                        $color = 'red';
                    } else {
                        $color = 'green';
                    }
                    return '<font color="' . $color . '">Valor Total: ' . Yii::$app->formatter->asCurrency($total) . '</font>';
                },
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        //'heading' => true,
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="glyphicon glyphicon-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar'])
            ],
            '{toggleData}',
        ],
         'showPageSummary' => true,
    ]);
    ?>


</div>
