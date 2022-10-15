<?php

use yii\helpers\Html;
use app\lib\grid\GridView;
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
<div class="operacao-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);    
    ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => 'padraoCajui',
        'boxTitle' => $this->title,

        'columns' => [
            'id',
            //'tipo:ntext',
            [
                'label' => 'Id Ativo',
                'attribute' => 'itens_ativos_id',
                'value' => 'itens_ativos_id',
                'options' => ['style' => 'width:10%;']
            ],
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_codigo',
                'value' => 'itensAtivo.ativos.codigo',
                'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 2],
            ],
            [
                'filter' => Operacao::tipoOperacao(),
                'attribute' => 'tipo',
                'value' => function ($model) {
                    return Operacao::getTipoOperacao($model->tipo);
                },
            ],
            [
                'attribute' => 'quantidade',
                //'format' => 'number',
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider) {
                    $quantidade = 0;
                    $objetos = $dataProvider->models;
                    foreach ($objetos as $operacao) {
                        $quantidade += $operacao->quantidade;
                    }
                    return '<font color="blue">Quatidade: ' . $quantidade . '</font>';
                }
            ],
            [
                'attribute' => 'valor',
                'format' => 'currency',
                'value' => function ($model) {
                    return $model->getValorCambio();
                },
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $total = 0;
                    foreach ($objetos as $operacao) {
                        if ($operacao->tipo == 0) {
                            //dinheiro entrando no meu bolso
                            $total += $operacao->getValorCambio();
                        } else {
                            //dinheiro saindo do meu bolso
                            $total -= $operacao->getValorCambio();
                        }
                    }
                    if ($total < 0) {
                        $color = 'red';
                    } else {
                        $color = 'green';
                    }
                    return '<font color="' . $color . '">Valor Total: ' . Yii::$app->formatter->asCurrency($total) . '</font>';
                },
                'pageSummaryOptions' => ['colspan' => 2],
            ],
            //'data',
            [
                'attribute' => 'data',
                'value' => function ($model) {
                    $date = date_create($model->data);
                    return date_format($date, 'd/m/Y H:i:s');
                },
                //'format' => 'datetime',
                //'format'=>'dd/mm/yyyy HH:MM',
                'filter' => DateRangePicker::widget($daterange),
                // 'format'     => 'dd/mm/yyyy',
            ],
            [
                'attribute' => 'investidor',
                'label' => 'Investidor',
                'value' => 'itensAtivo.investidor.nome',
            ],
            [
                'class' => 'app\lib\grid\ActionColumn',
            ],
        ],
        'showPageSummary' => true,
    ]);
    ?>


</div>