<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AcaoBolsa */

$this->title = 'Cria Acao Bolsa';
$this->params['breadcrumbs'][] = ['label' => 'Acao Bolsas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="acao-bolsa-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
