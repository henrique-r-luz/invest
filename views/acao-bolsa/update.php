<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AcaoBolsa */

$this->title = 'Atualiza Acao Bolsa';
$this->params['breadcrumbs'][] = ['label' => 'Acao Bolsas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="acao-bolsa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
