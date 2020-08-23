<?php

use app\models\AcaoBolsaSearch;
use kartik\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\web\View;

//use kartik\icons\Icon;
// Maps the Elusive icon font framework
//Icon::map($this);  
/* @var $this View */
/* @var $searchModel AcaoBolsaSearch */
/* @var $dataProvider ActiveDataProvider */
$largura = 0.25
?>




<?=

GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'font-size:11px; table-layout:fixed;'],
    'columns' => [
        [
            'attribute' => 'data',
            'value' => function($model) use($trimestre) {
                if ($trimestre) {
                    return $model->data;
                } else {
                    $ano = explode("-", $model->data);
                    return $ano[0];
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
        ],
        [
            'attribute' => 'patrimonio_liquido',
            // 'format' => 'html',
            'format' => 'html',
            'value' => function($model) {
                if ($model->patrimonio_liquido > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->patrimonio_liquido) . '</font>';
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
        ],
        [
            'attribute' => 'receita_liquida',
            'format' => 'html',
            'value' => function($model) {
                if ($model->receita_liquida > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->receita_liquida) . '</font>';
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
        ],
        ['attribute' => 'ebitda',
            'value' => function($model) {
                if ($model->ebitda > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }

                if ($model->ebitda == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->ebitda) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false,
        ],
        /* [
          'attribute' => 'da',
          'hidden' => ($empresa->setor == 'Bancos') ? true : false,
          'value' => function($model) {
          if ($model->da == null) {
          return'';
          } else {
          return $model->da;
          }
          },
          ], */
        ['attribute' => 'ebit',
            'value' => function($model) {
                if ($model->ebit > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->ebit == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->ebit) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false,
        ],
        ['attribute' => 'resultado_financeiro',
            'value' => function($model) {
                if ($model->resultado_financeiro > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->resultado_financeiro == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->resultado_financeiro) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false,
        ],
        /* ['attribute' => 'imposto',
          'value' => function($model) {
          if ($model->imposto == null) {
          return'';
          } else {
          return $model->imposto;
          }
          },], */
        ['attribute' => 'margem_ebit',
            'value' => function($model) {
                if ($model->margem_ebit > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->margem_ebit == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->margem_ebit) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false,],
        ['attribute' => 'lucro_liquido',
            'value' => function($model) {
                if ($model->lucro_liquido > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->lucro_liquido == null) {
                    return'';
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->lucro_liquido) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',],
        ['attribute' => 'margem_liquida',
            'value' => function($model) {
                if ($model->margem_liquida > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->margem_liquida == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->margem_liquida) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',],
        ['attribute' => 'roe',
            'value' => function($model) {
                if ($model->roe > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->roe == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->roe) . '</font>';
                }
            },
            'format' => 'html',],
        ['attribute' => 'caixa',
            'value' => function($model) {
                if ($model->caixa > 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->caixa == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->caixa) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false],
        ['attribute' => 'divida_bruta',
            'value' => function($model) {
                if ($model->divida_bruta <= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->divida_bruta == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->divida_bruta) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false,],
        ['attribute' => 'divida_liquida',
            'value' => function($model) {
                if ($model->divida_liquida <= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->divida_liquida == null) {
                    return'';
                } else {
                    return $model->divida_liquida;
                }
                return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->divida_bruta) . '</font>';
            },],
        /* ['attribute' => 'divida_bruta_patrimonio',
          'value' => function($model) {
          if ($model->divida_bruta_patrimonio == null) {
          return'';
          } else {
          return $model->divida_bruta_patrimonio;
          }
          },
          ], */
        ['attribute' => 'divida_liquida_ebitda',
            'value' => function($model) {
                if ($model->divida_liquida_ebitda <= 3) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->divida_liquida_ebitda == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->divida_liquida_ebitda) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false,
        ],
        ['attribute' => 'fco',
            'value' => function($model) {
                if ($model->fco >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->fco == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->fco) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false]
        ,
        ['attribute' => 'capex',
            'value' => function($model) {
                if ($model->capex >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->capex == null) {
                    return 0;
                } else {
                    $color = '';
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->capex) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false],
        ['attribute' => 'fcf',
            'value' => function($model) {
                if ($model->fcf >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->fcf == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->fcf) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false],
        ['attribute' => 'fcl',
            'value' => function($model) {
                if ($model->fcl >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->fcl == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->fcl) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false],
        ['attribute' => 'fcl_capex',
            'value' => function($model) {
                if ($model->fcl_capex >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->fcl_capex == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->fcl_capex) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
            'hidden' => ($empresa->setor == 'Bancos') ? true : false],
        ['attribute' => 'proventos',
            'value' => function($model) {
                if ($model->proventos >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->proventos == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->proventos) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
        ],
        ['attribute' => 'payout',
            'value' => function($model) {
                if ($model->payout >= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->payout == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->payout) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',],
        [
            'attribute' => 'pdd',
            'hidden' => ($empresa->setor == 'Bancos') ? false : true,
            'value' => function($model) {
                if ($model->pdd <= 0) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->pdd == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->pdd) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
        ],
        [
            'attribute' => 'pdd_lucro_liquido',
            'hidden' => ($empresa->setor == 'Bancos') ? false : true,
            'value' => function($model) {
                if ($model->pdd_lucro_liquido <= 75) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->pdd_lucro_liquido == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->pdd_lucro_liquido) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
        ],
        [
            'attribute' => 'indice_basileia',
            'hidden' => ($empresa->setor == 'Bancos') ? false : true,
            'value' => function($model) {
                if ($model->indice_basileia >= 11) {
                    $color = 'green';
                } else {
                    $color = 'red';
                }
                if ($model->indice_basileia == null) {
                    return 0;
                } else {
                    return '<font color="' . $color . '"> ' . Yii::$app->formatter->asDecimal($model->indice_basileia) . '</font>';
                }
            },
            'contentOptions' => ['style' => 'width:' . $largura . '%;'],
            'format' => 'html',
        ],
    ],
    'hover' => true,
    'responsive' => true,
    'toolbar' => null,
    'responsiveWrap' => false,
    'summary' => false,
    'floatHeader' => true,
    'resizableColumns' => true,
    'floatHeaderOptions' => [
        //'scrollingTop' => '0',
        'position' => 'absolute',
        'resizeFromBody' => true,
        'top' => 5
    ],
    'resizableColumns' => true,
    'resizableColumnsOptions' => ['resizeFromBody' => true],
    'persistResize' => true,
]);

$this->registerJs(
        
        "
        var mudou =   document.getElementsByClassName('sidebar-collapse').length;  
        window.onscroll = function (oEvent) {
                var table = $('table');
           
               if(mudou!=document.getElementsByClassName('sidebar-collapse').length){
                        table.floatThead('reflow');
                        mudou =   document.getElementsByClassName('sidebar-collapse').length;
               }
        }",
        View::POS_READY,
        'my-button-handler'
);
?>



