<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImport */

$this->title = 'Atualiza Operacoes Import';
$this->params['breadcrumbs'][] = ['label' => 'Operacoes Imports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="operacoes-import-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
