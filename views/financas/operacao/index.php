<?php

use Yii;
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

        'columns' => [
            'id',
            [
                'label' => 'Ativo',
                'attribute' => 'ativo_codigo',
                'value' => function ($model) {
                    return $model->ativo_id . ' - ' . $model->ativo_codigo;
                },
                'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 2],
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
                //'format' => 'datetime',
                //'format'=>'dd/mm/yyyy HH:MM',
                'filter' => DateRangePicker::widget($daterange),
                // 'format'     => 'dd/mm/yyyy',
            ],
            [
                'attribute' => 'investidor',
                'label' => 'Investidor',
                //  'value' => 'itensAtivo.investidor.nome',
            ],
            [
                'class' => 'app\lib\grid\ActionColumn',
            ],
        ],
        'showPageSummary' => true,
    ]);
    ?>


</div>