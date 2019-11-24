<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operacao */

$this->title = 'Atualiza Operacao';
$this->params['breadcrumbs'][] = ['label' => 'Operacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="operacao-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
