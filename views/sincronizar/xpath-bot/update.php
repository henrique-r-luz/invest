<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\XpathBot */

$this->title = 'Atualiza Xpath Bot';
$this->params['breadcrumbs'][] = ['label' => 'Xpath Bots', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $id, 'url' => ['view', 'id' => $id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="xpath-bot-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>