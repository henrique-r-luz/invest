<?php

use yii\helpers\Html;
use \kartik\grid\GridView;

//use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AtivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ativos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ativo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' =>'id',
                 'pageSummary' => 'EXTRATO FINANCEIRO',
                'pageSummaryOptions' => ['colspan' => 3],
                'options' => ['style' => 'width:5%;'],
            ],

            [
                'attribute' => 'codigo',
                'value' => 'codigo',
               
            ],
            'quantidade',
            [
                'attribute' => 'valor_compra',
                'format' => 'currency',
                'pageSummary' => true,
            ],

            [
                'attribute' => 'valor_bruto',
                'format' => 'currency',
                'pageSummary' => true,
            ],

            [
                'attribute' => 'valor_liquido',
                'format' => 'currency',
                'pageSummary' => true
            ],
            [
                'filter'  => app\lib\Tipo::all(),
                'attribute' => 'tipo',
                'label' => 'Tipo',
                'value' => function($model) {
                    if (isset($model->acaoBolsa->setor)) {
                        return $model->tipo . ' (' . $model->acaoBolsa->setor . ')';
                    }else{
                        return $model->tipo;
                    }
                },
                'pageSummary' => function ($summary, $data, $widget)use($dataProvider) {
                    //var_dump($dataProvider);
                   // print_r($dataProvider->models);
                    $objetos = $dataProvider->models;
                    $lucro = 0;
                    $valorLiquidoAcao = 0;
                    $valorCompraAcao = 0;
                    $lucroAcao = 0;
                    foreach ($objetos as $ativo){
                        //renda fixa
                        if($ativo->categoria== app\lib\Categoria::RENDA_FIXA){
                            $lucro = $lucro+($ativo->valor_liquido-$ativo->valor_compra);
                        }
                        //ações
                        if($ativo->tipo== \app\lib\Tipo::ACOES || $ativo->tipo== \app\lib\Tipo::Criptomoeda ){
                          
                            $valorLiquidoAcao = $valorLiquidoAcao+$ativo->valor_liquido;
                            $valorCompraAcao = $valorCompraAcao+$ativo->valor_compra;          
                        }
                    }

                   //remove 15 % do lucro
                    if(($valorLiquidoAcao-$valorCompraAcao)>0){
                        $lucroAcao =(($valorLiquidoAcao-$valorCompraAcao)*0.85);
                        
                    }else{
                        $lucroAcao = ($valorLiquidoAcao-$valorCompraAcao);
                    }
                    $lucro = $lucro+$lucroAcao;
                    if($lucro>0){
                        $color = 'green';
                    }else{
                         $color = 'red';
                    }
                    return '<font color="'.$color.'">Lucro/Prejuízo: '.Yii::$app->formatter->asCurrency($lucro).'</font>';
                },
                'pageSummaryOptions' => ['colspan' => 3],
            ],
            [
                'filter'  => app\lib\Categoria::all(),
                'attribute' => 'categoria',
                'label' => 'Categoria',
                'value' => 'categoria',
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
