<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Investidor */

$this->title = 'Cria Investidor';
$this->params['breadcrumbs'][] = ['label' => 'Investidors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="investidor-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
