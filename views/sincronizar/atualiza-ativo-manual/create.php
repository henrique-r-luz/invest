<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaAtivoManual */

$this->title = 'Cria Atualiza Ativo Manual';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Ativo Manuals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-ativo-manual-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
