<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\lib\grid\GridView;
use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use app\lib\config\ValorDollar;
use app\models\financas\Operacao;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operacões';
$this->params['breadcrumbs'][] = $this->title;
$daterange = [
    'model' => $searchModel,
    'attribute' => 'createTimeRange',
    'convertFormat' => true,
    'pjaxContainerId' => 'grid_pjax',
    //'presetDropdown' => true,
    'pluginOptions' => [
        'timePicker' => true,
        'timePicker24Hour' => true,
        'timePickerIncrement' => 10,
        'locale' => ['format' => 'd/m/Y H:i:s']
    ],
];
?>
<div class="operacao-index">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => 'padraoCajui',
        'boxTitle' => $this->title,
        'id' => 'grid_index',

        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['style' => 'width:5
                %;'],
            ],
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_codigo',
                'value' => function ($model) {
                    return $model->ativo_id . ' - ' . $model->ativo_codigo;
                },
                'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 2],
                // 'options' => ['style' => 'width:3%;'],
            ],
            [
                'filter' => Tipo::all(),
                'attribute' => 'tipo_ativo',
                'label' => 'Tipo Ativo',

            ],

            [
                'filter' => Operacao::tipoOperacao(),
                'attribute' => 'tipo',
                'value' => function ($model) {
                    return Operacao::getTipoOperacao($model->tipo);
                },
            ],
            [
                'format' => ['decimal'],
                'attribute' => 'quantidade',
                //'format' => 'number',
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider) {
                    $quantidade = 0;
                    $objetos = $dataProvider->models;
                    foreach ($objetos as $operacao) {
                        if (
                            $operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]
                            || $operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS]
                        ) {
                            $quantidade -= $operacao->quantidade;
                        } else {
                            $quantidade += $operacao->quantidade;
                        }
                    }
                    return '<font color="blue">Quatidade: ' . $quantidade . '</font>';
                }
            ],
            [
                'attribute' => 'valor',
                'format' => 'currency',
                'value' => function ($model) {
                    return ValorDollar::convertValorMonetario($model->valor, $model->pais);
                },
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $total = 0;
                    foreach ($objetos as $operacao) {

                        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
                            //dinheiro entrando no meu bolso
                            $total += ValorDollar::convertValorMonetario($operacao->valor, $operacao->pais); //$operacao->getValorCambio();
                        } else {
                            //dinheiro saindo do meu bolso
                            $total -= ValorDollar::convertValorMonetario($operacao->valor, $operacao->pais);
                        }
                    }
                    // $total = ValorDollar::convertValorMonetario($total, $operacao->itensAtivo->ativos->pais);
                    if ($total < 0) {
                        $color = 'red';
                    } else {
                        $color = 'green';
                    }
                    return '<font color="' . $color . '">Valor Total: ' . Yii::$app->formatter->asCurrency($total) . '</font>';
                },
                'pageSummaryOptions' => ['colspan' => 2],
            ],
            [
                'attribute' => 'data',
                'value' => function ($model) {
                    $date = date_create($model->data);
                    return date_format($date, 'd/m/Y H:i:s');
                },
                //'filter' => GridView::FILTER_DATE_RANGE,
                'filter' => DateRangePicker::widget($daterange),

            ],
            [
                'attribute' => 'investidor',
                'label' => 'Investidor',

            ],
            [
                'filter' => Pais::all(),
                'attribute' => 'pais',
                'label' => 'País',
                /* 'value' => function ($model) {
                    // itensAtivo->ativos
                    return $model->pais;
                }*/
                // 'value' => 'itens_ativo.ativos.pais',
            ],
            [
                'class' => 'app\lib\grid\ActionColumn',

            ],
        ],
        'showPageSummary' => true,
    ]);
    ?>


</div>