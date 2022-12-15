<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\AtualizaAcao */

$this->title = 'Atualiza Atualiza Acao';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Acaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ativo_id, 'url' => ['view', 'id' => $model->ativo_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="atualiza-acao-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
