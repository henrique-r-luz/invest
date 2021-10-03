<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\BalancoEmpresaBolsa */

$this->title = 'Cria Balanco Empresa Bolsa';
$this->params['breadcrumbs'][] = ['label' => 'Balanco Empresa Bolsas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="balanco-empresa-bolsa-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
