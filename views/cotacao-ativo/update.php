<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CotacaoAtivo */

$this->title = 'Atualiza Cotacão Ativo';
$this->params['breadcrumbs'][] = ['label' => 'Cotacao Ativos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cotacao-ativo-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
