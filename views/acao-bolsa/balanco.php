<?php

use app\models\AcaoBolsaSearch;
use kartik\tabs\TabsX;
use yii\data\ActiveDataProvider;
use app\lib\BoxCollapse;
use yii\web\View;

//use kartik\icons\Icon;
// Maps the Elusive icon font framework
//Icon::map($this);  
/* @var $this View */
/* @var $searchModel AcaoBolsaSearch */
/* @var $dataProvider ActiveDataProvider */

$this->title = $empresa->nome;
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="acao-bolsa-index">

    <?php
    BoxCollapse::begin([
        'type' => BoxCollapse::TYPE_PRIMARY,
        'title' => 'Planilha de Dados',
            //'collapseRemember' => false
    ])
    ?>
    <div class="box">
        <div class="box-body">
            <?=
            TabsX::widget([
                'items' => [
                    [
                        'label' => 'Dados Anuais',
                        'content' => $this->render('_grid', [
                            'dataProvider' => $providerBalancoDadosAnos,
                            'empresa' => $empresa,
                            'trimestre' => false,
                        ]),
                        'active' => true,
                        'encode' => true,
                    ],
                    [
                        'label' => 'Dados Trimestrais',
                        'content' => $this->render('_grid', [
                            'dataProvider' => $providerBalancoDadosTrimestre,
                            'empresa' => $empresa,
                            'trimestre' => true,
                        ]),
                        'active' => false,
                        'encode' => true,
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
            ])
            ?>
        </div>
    </div>
    <?php BoxCollapse::end() ?>
    <?php
    BoxCollapse::begin([
        'type' => BoxCollapse::TYPE_PRIMARY,
        'title' => 'Graficos de Indicadores',
            //'collapseRemember' => false
    ])
    ?>
    <div class="box">
        <div class="box-body">            
              <?=
            TabsX::widget([
                'items' => [
                    [
                        'label' => 'Dados Anuais',
                        'content' => $this->render('_grafico', [
                            'graficoAno'=>$graficoAno,
                        ]),
                        'active' => true,
                        'encode' => true,
                    ],
                    [
                        'label' => 'Dados Trimestrais',
                        'content' => $this->render('_grafico', [
                            'graficoAno'=>$graficoAno,
                        ]),
                        'active' => false,
                        'encode' => true,
                    ],
                ],
                'position' => TabsX::POS_ABOVE,
                'bordered' => true,
            ])
            ?>
        </div>
          
        </div>
    </div>
    <?php BoxCollapse::end() ?>


</div>
