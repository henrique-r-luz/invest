<?php

/* @var $this View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Evolução Patrimonio';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="index">

<?= $this->render('_grafico',['dados'=>$dados]); ?>
    
</div>    


