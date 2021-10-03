<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\financas\AtualizaAcao */

$this->title = 'Cria Atualização Ação';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Acaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-acao-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
