<?php

use yii\helpers\Html;
use app\lib\grid\GridView;
use yii\helpers\Url;
//use kartik\icons\Icon;


 // Maps the Elusive icon font framework
//Icon::map($this);  
/* @var $this yii\web\View */
/* @var $searchModel app\models\AcaoBolsaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Empresas da Bolsa';
$this->params['breadcrumbs'][] = $this->title;
?>
 

<div class="acao-bolsa-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'cnpj',
            'codigo',
            'nome:ntext',
            'setor:ntext',
            [
                'class' => 'app\lib\grid\ActionColumn',
                'template' => '{view} {update} {delete} {balanco}',
                'buttons' => [
                    'balanco'=>function ($url, $model){
                         $title   = 'balanços';
                            $label   = '<button type="button" class="btn btn-warning btn-xs"><i class="fa fa-balance-scale"></i></button>';
                            $options = ['title' => $title, 'data-pjax' => '0'];
                            return Html::a($label, Url::toRoute(['balanco', 'codigo_empresa' => $model->codigo]), $options);
                    }, 
                ],
            ],
        ],
        'toolbar'=>'padraoCajui',
        'boxTitle' => $this->title,
    ]);
    ?>


</div>
