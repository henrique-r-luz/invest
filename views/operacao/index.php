<?php

use yii\helpers\Html;
use \kartik\grid\GridView;
use \app\models\Operacao;
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
        'timePicker24Hour'=> true,
        'timePickerIncrement' => 10,
        //'locale' => ['format' => 'Y-m-d H:i']
        'locale' => ['format' => 'd/m/Y H:i:s']
       //'locale' => ['dd/MM/yyyy HH:mm']
    ],
];

?>
<div class="operacao-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);   ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //      'id',
            //'tipo:ntext',
            [
                'label' => 'Ativo Código',
                'attribute' => 'ativo_codigo',
                'value' => 'ativo.codigo',
                'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 2],
            ],
            [
                'filter' => Operacao::tipoOperacao(),
                'attribute' => 'tipo',
                'value' => function($model) {
                    return Operacao::getTipoOperacao($model->tipo);
                },
            ],
            [
                'attribute' => 'quantidade',
                'format' => 'decimal',
                'pageSummary' => function ($summary, $data, $widget)use($dataProvider) {
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
                'pageSummary' => function ($summary, $data, $widget)use($dataProvider) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $total = 0;
                    foreach ($objetos as $operacao) {
                        if ($operacao->tipo == 0) {
                            //dinheiro entrando no meu bolso
                            $total += $operacao->valor;
                        } else {
                            //dinheiro saindo do meu bolso
                            $total -= $operacao->valor;
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
                'format' => 'datetime',
                //'format'=>'dd/mm/yyyy HH:MM',
                'filter' => DateRangePicker::widget($daterange),
            // 'format'     => 'dd/mm/yyyy',
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
        'panel' => [
            'type' => GridView::TYPE_DEFAULT,
        //'heading' => true,
        ],
        'toolbar' => [
            'content' => Html::a('<i class="glyphicon glyphicon-plus"></i> ', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']) .
            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['class' => 'btn btn-default', 'title' => 'Limpar Filtros']),
            '{toggleData}',
        ],
        'showPageSummary' => true,
    ]);
    ?>


</div>
