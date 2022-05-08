<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\admin\User */

$this->title = 'Cria User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
