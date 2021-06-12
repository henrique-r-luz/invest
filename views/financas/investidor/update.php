<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Investidor */

$this->title = 'Atualiza Investidor';
$this->params['breadcrumbs'][] = ['label' => 'Investidors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="investidor-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
