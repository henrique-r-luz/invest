<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\sincronizar\AtualizaOperacoesManual */

$this->title = 'Cria Atualiza Operação Manual';
$this->params['breadcrumbs'][] = ['label' => 'Atualiza Operacõess Manual', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="atualiza-operacoes-manual-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>