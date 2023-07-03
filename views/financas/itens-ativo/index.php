<?php

use app\lib\config\ValorDollar;
use app\lib\grid\GridView;
use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use app\lib\dicionario\Categoria;

//use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\AtivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ativos Investidos';
$this->params['breadcrumbs'][] = $this->title;
$impostoRenda = 1;
?>
<div class="ativo-index">
    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'toolbar' => 'padraoCajui',
        'boxTitle' => $this->title,
        'columns' => [
            [
                'attribute' => 'id',
                'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 2],
                'options' => ['style' => 'width:3%;'],
            ],
            [
                'attribute' => 'codigo',
                'value' => 'ativos.codigo',
                'value' => function ($model) {
                    return $model->ativos->id . ' - ' . $model->ativos->codigo;
                },
                'options' => ['style' => 'width:12%;'],
            ],
            [
                'format' => ['decimal'],
                'attribute' => 'quantidade',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'valor_compra',
                'value' => function ($model) {
                    return round(ValorDollar::convertValorMonetario($model->valor_compra, $model->ativos->pais), 4);
                },
                'format' => 'currency',
                'pageSummary' => true,
            ],
            [
                'attribute' => 'valor_bruto',
                'format' => 'currency',
                'value' => function ($model) {
                    return round(ValorDollar::convertValorMonetario($model->valor_bruto, $model->ativos->pais), 4);
                },
                'pageSummary' => true,
            ],
            [
                'filter' => Tipo::all(),
                'attribute' => 'tipo',
                'label' => 'Tipo',
                'value' => function ($model) {
                    return $model->ativos->tipo;
                },
                'pageSummary' => function ($summary, $data, $widget) use ($dataProvider, $impostoRenda) {

                    $objetos = $dataProvider->models;
                    $lucro = 0;
                    $lucroAcao = 0;
                    foreach ($objetos as $ativo) {
                        if ($ativo->ativos->categoria == Categoria::RENDA_FIXA) {
                            $lucro = $lucro + (ValorDollar::convertValorMonetario($ativo->valor_bruto, $ativo->ativos->pais) - ValorDollar::convertValorMonetario($ativo->valor_compra, $ativo->ativos->pais));
                        } else {
                            $lucroAcao = $lucroAcao + (ValorDollar::convertValorMonetario($ativo->valor_bruto, $ativo->ativos->pais) - ValorDollar::convertValorMonetario($ativo->valor_compra, $ativo->ativos->pais));
                        }
                    }

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
                'filter' => Categoria::all(),
                'attribute' => 'categoria',
                'label' => 'Categoria',
                'value' => 'ativos.categoria',
            ],
            [
                'attribute' => 'investidor_id',
                'label' => 'Investidor',
                'value' => 'investidor.nome',
            ],
            [
                'filter' => Pais::all(),
                'attribute' => 'pais',
                'label' => 'País',
                'value' => 'ativos.pais',
            ],
            ['class' => 'app\lib\grid\ActionColumn'],
        ],
        'showPageSummary' => true,
    ]);
    ?>


</div>