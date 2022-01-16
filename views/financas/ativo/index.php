<?php

use yii\helpers\Html;
use \kartik\grid\GridView;
use Mpdf\Tag\Summary;

//use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\AtivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ativos';
$this->params['breadcrumbs'][] = $this->title;
$impostoRenda = 1;
$layout = <<< HTML
<div class="float-right">
    {summary}
</div>
{custom}
<div class="clearfix"></div>
{items}
{pager}
HTML;
?>
<div class="ativo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  
    ?>
    <div class="card card-success card-outline">
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
                        'options' => ['style' => 'width:20%;'],
                    ],


                    [
                        'filter' => app\lib\Tipo::all(),
                        'attribute' => 'tipo',
                        'label' => 'Tipo',
                        'value' => function ($model) {
                            // return 'tipo';
                            if (isset($model->acaoBolsa->setor)) {
                                return $model->tipo . ' (' . $model->acaoBolsa->setor . ')';
                            } else {
                                return $model->tipo;
                            }
                        }
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
                'summary'=>false,
                /* 'panel' => [
            'type' => GridView::TYPE_INFO,
            //'heading' => true,
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="fa fa-plus"></i>', ['create'], ['class' => 'btn btn-success', 'title' => 'Adicionar']),
               
            ],
            '{toggleData}',
        ],*/
            ]);
            ?>
    </div>
</div>