<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

//use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\AtivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ativos';
$this->params['breadcrumbs'][] = $this->title;
$impostoRenda = 1;
?>
<div class="ativo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 2],
                'options' => ['style' => 'width:5%;'],
            ],
            [
                'attribute' => 'codigo',
                'value' => 'codigo',
            ],
            [
                'attribute' => 'quantidade',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'valor_compra',
                'value' => function($model) {
                    return $model->valor_compra; //app\models\financas\Ativo::valorCambio($model, $model->valor_compra);
                },
                'format' => 'currency',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'valor_bruto',
                'format' => 'currency',
                'pageSummary' => true,
            ],
            [
                'filter' => app\lib\Tipo::all(),
                'attribute' => 'tipo',
                'label' => 'Tipo',
                'value' => function($model) {
                    if (isset($model->acaoBolsa->setor)) {
                        return $model->tipo . ' (' . $model->acaoBolsa->setor . ')';
                    } else {
                        return $model->tipo;
                    }
                },
                'pageSummary' => function ($summary, $data, $widget)use($dataProvider, $impostoRenda) {
                    //var_dump($dataProvider);
                    // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $lucro = 0;
                    $valorLiquidoAcao = 0;
                    $valorCompraAcao = 0;
                    $lucroAcao = 0;
                    foreach ($objetos as $ativo) {
                        //renda fixa
                        if ($ativo->categoria == app\lib\Categoria::RENDA_FIXA) {
                            $lucro = $lucro + ($ativo->valor_bruto - $ativo->valor_compra);
                        } else {
                            $lucroAcao = $lucroAcao + ($ativo->valor_bruto - $ativo->valor_compra);
                        }
                    }

                    //remove 15 % do lucro



                    $lucro = $lucro + $lucroAcao;
                    if ($lucro > 0) {
                        $color = 'green';
                    } else {
                        $color = 'red';
                    }
                    return '<font color="' . $color . '">Lucro/Prejuízo: ' . Yii::$app->formatter->asCurrency($lucro) . '</font>';
                },
                'pageSummaryOptions' => ['colspan' => 3],
            ],
            [
                'filter' => app\lib\Categoria::all(),
                'attribute' => 'categoria',
                'label' => 'Categoria',
                'value' => 'categoria',
            ],
            [
                'filter' => \app\lib\Pais::all(),
                'attribute' => 'pais',
                'label' => 'País',
                'value' => 'pais',
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
