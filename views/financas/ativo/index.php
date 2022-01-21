<?php

use yii\helpers\Html;
use app\lib\grid\GridView;
use Mpdf\Tag\Summary;

//use Yii;

/* @var $this yii\web\View */
/* @var $searchModel app\models\financas\AtivoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ativos';
$this->params['breadcrumbs'][] = $this->title;
$impostoRenda = 1;
?>
<div class="ativo-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  
    ?>
    
            <?=
            GridView::widget([
                'toolbar'=>'padraoCajui',
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
                    ['class' => 'app\lib\grid\ActionColumn'],
                ],
                'boxTitle' => $this->title,
            ]);
            ?>
</div>