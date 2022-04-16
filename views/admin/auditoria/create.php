<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\admin\Auditoria */

$this->title = 'Cria Auditoria';
$this->params['breadcrumbs'][] = ['label' => 'Auditorias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auditoria-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
