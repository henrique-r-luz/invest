<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Ativo */

$this->title = 'Cria Item Ativo';
$this->params['breadcrumbs'][] = ['label' => 'Ativos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ativo-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>