<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\Proventos */

$this->title = 'Cria Proventos';
$this->params['breadcrumbs'][] = ['label' => 'Proventos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proventos-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
