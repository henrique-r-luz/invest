<?php

use app\lib\Atributos;
use app\lib\dicionario\Tempo;
use app\models\financas\AcaoBolsa;
use kartik\widgets\Select2;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $searchModel app\models\OperacaoSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Proventos Por Valor Atual';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="index">

    <?= $this->render('_grafico', ['dados' => $dados]); ?>

</div>