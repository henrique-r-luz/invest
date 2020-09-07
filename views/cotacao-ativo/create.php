<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CotacaoAtivo */

$this->title = 'Cria Cotacão Ativo';
$this->params['breadcrumbs'][] = ['label' => 'Cotacao Ativos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cotacao-ativo-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
