<?php

use yii\web\View;
use yii\helpers\Html;
use app\lib\grid\GridView;
use app\lib\dicionario\Pais;
use app\models\financas\Ativo;
use yii\data\ActiveDataProvider;
use kartik\daterange\DateRangePicker;
use app\models\financas\ProventosSearch;

/* @var $this View */
/* @var $searchModel ProventosSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Proventos';
$this->params['breadcrumbs'][] = $this->title;

$daterange = [
    'model' => $searchModel,
    'attribute' => 'createTimeRange',
    'convertFormat' => true,
    'pluginOptions' => [
        'timePicker' => true,
        'timePicker24Hour' => true,
        'timePickerIncrement' => 10,
        //'locale' => ['format' => 'Y-m-d H:i']
        'locale' => ['format' => 'd/m/Y H:i:s']
        //'locale' => ['dd/MM/yyyy HH:mm']
    ],
];
?>
<div class="proventos-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => 'padraoCajui',
        'boxTitle' => $this->title,
        'columns' => [
            [
                'label' => 'Id Ativo',
                'attribute' => 'itens_ativos_id',
                'value' => 'itensAtivo.id',
                'options' => ['style' => 'width:10%;']
            ],
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_codigo',
                'value' => 'itensAtivo.ativos.codigo',
            ],
            [
                'attribute' => 'valor',
                'format' => 'currency',
                'value' => function ($model) {
                    return Ativo::valorCambio($model->itensAtivo->ativos, $model->valor);
                },
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $total = 0;
                    foreach ($objetos as $provento) {
                        $valorCambio = Ativo::valorCambio($provento->itensAtivo->ativos, $provento->valor);
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
            [
                'attribute' => 'data',
                'format' => 'datetime',
                //'format'=>'dd/mm/yyyy HH:MM',
                'filter' => DateRangePicker::widget($daterange),
                // 'format'     => 'dd/mm/yyyy',
            ],
            [
                'filter' => Pais::all(),
                'attribute' => 'pais',
                'label' => 'País',
                'value' => function ($model) {
                    return $model->itensAtivo->ativos->pais;
                }
            ],
            [
                'attribute' => 'investidor',
                'label' => 'Investidor',
                'value' => 'itensAtivo.investidor.nome',
            ],
            ['class' => 'app\lib\grid\ActionColumn'],
        ],

        'showPageSummary' => true,
    ]);
    ?>


</div>