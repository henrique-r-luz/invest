<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BalancoEmpresaBolsa */

$this->title = 'Atualiza Balanco Empresa Bolsa';
$this->params['breadcrumbs'][] = ['label' => 'Balanco Empresa Bolsas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="balanco-empresa-bolsa-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
