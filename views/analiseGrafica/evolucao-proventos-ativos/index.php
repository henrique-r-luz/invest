<?php


/* @var $this View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Evolução Proventos Ativo';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="index">

    <?= $this->render('_search', ['itensAtivo' => $itensAtivo]) ?>

    <?php if (!empty($dados->getDataTime())) : ?>
        <?= $this->render('_grafico', [
            'dados' => $dados,
        ]) ?>
    <?php endif ?>

</div>