<?php

use app\models\TipoSearch;
use app\lib\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;
use yii\widgets\Pjax;
use yii\helpers\Html;

/* @var $this View */
/* @var $searchModel TipoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Operaçoes de Venda';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="bens_direitos">
    <?= $this->render('_search', ['formBensDireitos' => $formBensDireitos]) ?>

    <?php if ($provider != null &&   $provider->count > 0) : ?>
        <?= $this->render('_grid', [
            'formBensDireitos' => $formBensDireitos,
            'provider' => $provider
        ]) ?>
    <?php endif ?>


    <?php if ($providerFii != null && $providerFii->count > 0) : ?>
        <?= $this->render('_grid_resumido_fii', [
            'providerFii' => $providerFii
        ]) ?>
    <?php endif ?>

    <?php if ($providerAcoes != null && $providerAcoes->count > 0) : ?>
        <?= $this->render('_grid_resumido_acoes', [
            'providerAcoes' => $providerAcoes
        ]) ?>
    <?php endif ?>

</div>