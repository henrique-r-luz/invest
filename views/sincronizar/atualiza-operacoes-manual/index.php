<?php

use yii\helpers\Html;
use app\lib\grid\GridView;
use app\lib\config\ValorDollar;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sincronizar\AtualizaOperacoesManualSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Atualiza Operação Manual';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-operacoes-manual-index">

        <?php // echo $this->render('_search', ['model' => $searchModel]); 
        ?>

        <?= GridView::widget([
                'toolbar' => 'padraoCajui',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'boxTitle' => $this->title,
                'columns' => [

                        [
                                'attribute' => 'id',
                                'options' => ['style' => 'width:5%;'],
                        ],
                        [
                                'attribute' => 'valor_bruto',
                                'format' => 'currency',
                                'value' => function ($model) {
                                        /** @var Operacao */

                                        return ValorDollar::convertValorMonetario($model->valor_bruto, $model->atualizaAtivoManual->itensAtivo->ativos->pais);
                                },
                        ],
                        [
                                'attribute' => 'valor_liquido',
                                'format' => 'currency',
                                'value' => function ($model) {
                                        /** @var Operacao */

                                        return ValorDollar::convertValorMonetario($model->valor_liquido, $model->atualizaAtivoManual->itensAtivo->ativos->pais);
                                },
                        ],
                        [
                                'attribute' => 'atualiza_ativo_manual_id',
                                'value' => function ($model) {
                                        return $model->atualizaAtivoManual->itensAtivo->ativos->codigo;
                                }
                        ],
                        [
                                'attribute' => 'data',
                                'value' => function ($model) {
                                        $date = date_create($model->data);
                                        return date_format($date, 'd/m/Y H:i:s');
                                },
                                //'format' => 'datetime',
                                //'format'=>'dd/mm/yyyy HH:MM',
                                // 'format'     => 'dd/mm/yyyy',
                        ],

                        ['class' => 'app\lib\grid\ActionColumn'],
                ],
        ]); ?>


</div>