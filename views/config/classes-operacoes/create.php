<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\ClassesOperacoes */

$this->title = 'Cria Classes Operacoes';
$this->params['breadcrumbs'][] = ['label' => 'Classes Operacoes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="classes-operacoes-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
