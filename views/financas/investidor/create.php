<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Investidor */

$this->title = 'Cria Investidores';
$this->params['breadcrumbs'][] = ['label' => 'Investidores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="investidor-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>