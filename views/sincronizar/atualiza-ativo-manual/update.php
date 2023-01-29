<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaAtivoManual */

$this->title = 'Atualiza Atualiza Ativo Manual';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Ativo Manuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="atualiza-ativo-manual-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
