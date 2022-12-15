<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\Preco */

$this->title = 'Cria Preço';
$this->params['breadcrumbs'][] = ['label' => 'Precos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="preco-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>