<?php

use app\lib\grid\GridView;
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
                'template' => '{view} {update} {delete}',
            ],
        ],
        'toolbar' => 'padraoCajui',
        'boxTitle' => $this->title,
    ]);
    ?>
</div>