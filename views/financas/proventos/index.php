<?php

use app\lib\grid\GridView;
use app\lib\dicionario\Pais;
use app\lib\config\ValorDollar;
use kartik\daterange\DateRangePicker;
use app\lib\dicionario\ProventosMovimentacao;

/* @var $this View */
/* @var $searchModel ProventosSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Proventos';
$this->params['breadcrumbs'][] = $this->title;

$daterange = [
    'model' => $searchModel,
    'attribute' => 'createTimeRange',
    'convertFormat' => true,
    'pjaxContainerId' => 'grid_pjax',
    'pluginOptions' => [
        'timePicker' => true,
        'timePicker24Hour' => true,
        'timePickerIncrement' => 10,
        'locale' => ['format' => 'd/m/Y H:i:s']
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
                'attribute' => 'id',
                'options' => [
                    'style' => 'width:6%;'
                ]
            ],
            [
                'label' => 'Iten Ativo Id',
                'attribute' => 'itens_ativos_id',
                'value' => 'itensAtivo.id',
                'options' => ['style' => 'width:10%;']
            ],
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_codigo',
                'value' => function ($model) {
                    return $model->itensAtivo->ativos->id . ' - ' . $model->itensAtivo->ativos->codigo;
                }
                //'value' => 'itensAtivo.ativos.codigo',
            ],
            [
                'attribute' => 'movimentacao',
                'filter' => ProventosMovimentacao::all(),
                'value' => function ($model) {
                    return ProventosMovimentacao::getNome($model->movimentacao);
                },
            ],
            [
                'attribute' => 'valor',
                'format' => 'currency',
                'value' => function ($model) {

                    return ValorDollar::convertValorMonetario($model->valor, $model->itensAtivo->ativos->pais);
                },
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $total = 0;
                    foreach ($objetos as $provento) {
                        $total += ValorDollar::convertValorMonetario($provento->valor, $provento->itensAtivo->ativos->pais);
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
                'filter' => DateRangePicker::widget($daterange),
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