<?php

use app\models\AcaoBolsaSearch;
use kartik\grid\GridView;
use kartik\tabs\TabsX;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\View;

//use kartik\icons\Icon;
// Maps the Elusive icon font framework
//Icon::map($this);  
/* @var $this View */
/* @var $searchModel AcaoBolsaSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = 'Balanços: ' . $empresa->nome;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="acao-bolsa-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>
    <div class="box">
        <div class="box-body">
            <?=
            TabsX::widget([
                'items' => [
                    [
                        'label' => 'Dados Anuais',
                        'content' => $this->render('_grid', [
                            'dataProvider' => $providerBalancoDadosAnos,
                        ]),
                        'active' => true,
                        'encode' => false,
                    ],
                    [
                        'label' => 'Dados Trimestrais',
                        'content' => $this->render('_grid', [
                            'dataProvider' => $providerBalancoDadosAnos,
                        ]),
                        'active' => false,
                        'encode' => false,
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
            ])
            ?>
        </div>
    </div>


</div>
