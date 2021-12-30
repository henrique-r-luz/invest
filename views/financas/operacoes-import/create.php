<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\OperacoesImport */

$this->title = 'Cria Operacoes Import';
$this->params['breadcrumbs'][] = ['label' => 'Operacoes Imports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacoes-import-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
