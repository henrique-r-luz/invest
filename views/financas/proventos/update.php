<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Proventos */

$this->title = 'Atualiza Proventos';
$this->params['breadcrumbs'][] = ['label' => 'Proventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="proventos-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>