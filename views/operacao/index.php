<?php

use yii\helpers\Html;
use \kartik\grid\GridView;
use \app\models\Operacao;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Operacões';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacao-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                    /*
                      //renda fixa
                      if ($ativo->categoria_id == 1) {
                      $lucro = $lucro + ($ativo->valor_liquido - $ativo->valor_compra);
                      }
                      //ações
                      if ($ativo->tipo_id == 7) {

                      $valorLiquidoAcao = $valorLiquidoAcao + $ativo->valor_liquido;
                      $valorCompraAcao = $valorCompraAcao + $ativo->valor_compra;
                      }
                      }


                      if (($valorLiquidoAcao - $valorCompraAcao) > 0) {
                      $lucroAcao = (($valorLiquidoAcao - $valorCompraAcao) * 0.85);
                      } else {
                      $lucroAcao = ($valorLiquidoAcao - $valorCompraAcao);
                      }
                      $lucro = $lucro + $lucroAcao;
                      if ($lucro > 0) {
                      $color = 'green';
                      } else {
                      $color = 'red';
                      }

                     *     return '<font color="' . $color . '">Lucro/Prejuízo: ' . Yii::$app->formatter->asCurrency($lucro) . '</font>';
                     */
                },
                'pageSummaryOptions' => ['colspan' => 2],
            ],
            //'data',
            [
                'attribute' => 'data',
                'format' => 'date',
                'filterType' => GridView::FILTER_DATETIME,
                'filterWidgetOptions' => [
                    'pickerButton' => false,
                    'pluginOptions' => [
                        'format' => 'dd/mm/yyyy',
                        'autoWidget' => true,
                        'autoclose' => true,
                    ],
                ]
            ],
            //'ativo_id',
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
