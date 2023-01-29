<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaOperacoesManual */

$this->title = 'Operação Manual';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Operação Manual', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="atualiza-operacoes-manual-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>