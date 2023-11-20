<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\XpathBot */

$this->title = 'Cria Xpath Bot';
$this->params['breadcrumbs'][] = ['label' => 'Xpath Bots', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="xpath-bot-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
