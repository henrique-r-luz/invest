<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\lib\grid\GridView;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OperacoesImportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


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
$this->title = 'Operacões Imports';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacoes-import-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                // 'toolbar' => 'padraoCajui',
                'boxTitle' => $this->title,
                'columns' => [

                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:7%;']
                        ],
                        [
                                'attribute' => 'investidor_id',
                                'value' => 'investidor.nome'

                        ],
                        [
                                'attribute' => 'arquivo'
                        ],
                        'tipo_arquivo:ntext',
                        [
                                'label' => 'Operações criadas',
                                'attribute' => 'lista_operacoes_criadas_json',
                        ],
                        [
                                'label' => 'Ativos Atualizados',
                                'attribute' => 'itens_ativos',
                                'value' => function ($model) {
                                        $id = 0;
                                        $itensAtivo = '';
                                        foreach ($model->itensAtivosImports as $itensAtivos) {
                                                if ($id != 0) {
                                                        $itensAtivo .= ', ';
                                                }
                                                $itensAtivo .= $itensAtivos->itensAtivo->ativos->codigo;
                                                $id++;
                                        }
                                        return $itensAtivo;
                                }
                        ],
                        [
                                'attribute' => 'data',
                                'filter' => DateRangePicker::widget($daterange),
                                'value' => function ($model) {
                                        $date = date_create($model->data);
                                        return date_format($date, 'd/m/Y H:i:s');
                                },
                        ],
                        [
                                'class' => 'app\lib\grid\ActionColumn',
                                'template' => '{view} {delete} {download}',
                                'buttons' => [
                                        'download' => static function ($url, $model) {
                                                $icon    = '<button type="button" class="btn btn-success btn-xs"><i class="fas fa-download"> </i> </button>';
                                                return Html::a($icon, Url::toRoute(['download', 'id' => $model->id]), []);
                                        },
                                ],
                        ],
                ],
        ]); ?>


</div>