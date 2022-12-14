<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\ClassesOperacoes */

$this->title = 'Atualiza Classes Operacoes';
$this->params['breadcrumbs'][] = ['label' => 'Classes Operacoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="classes-operacoes-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
