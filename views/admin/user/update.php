<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\admin\User */

$this->title = 'Atualiza User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">
    <?php $model->password = ''; ?>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
