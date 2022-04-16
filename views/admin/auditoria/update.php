<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\admin\Auditoria */

$this->title = 'Atualiza Auditoria';
$this->params['breadcrumbs'][] = ['label' => 'Auditorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="auditoria-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
