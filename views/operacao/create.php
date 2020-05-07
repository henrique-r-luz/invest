<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operacao */

$this->title = 'Cria Operação';
$this->params['breadcrumbs'][] = ['label' => 'Operacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operacao-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
