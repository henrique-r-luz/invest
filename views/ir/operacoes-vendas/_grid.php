<?php

use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'toolbar' => [],
    'columns' => [
        [
            'label' => 'Código',
            'attribute' => 'ativo_codigo',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Quantidade',
            'attribute' => 'quantidade',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Preco Medio',
            'format' => ['decimal', 2],
            //  'format' => 'currency',
            'attribute' => 'preco_medio',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Valor Compra',
            'format' => ['decimal', 2],
            //  'format' => 'currency',
            'attribute' => 'valor_compra',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Valor Venda',
            'format' => ['decimal', 2],
            // 'format' => 'currency',
            'attribute' => 'valor_venda',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            //'format' => 'currency',
            //'format' => ['decimal', 2],
            'attribute' => 'resultado',
            'value' => function ($model) {
                return round($model->resultado ?? 0, 2);
            }
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Tipo',
            'attribute' => 'tipo_ativo',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'pais',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'data',
            'format' => ['date', 'php:m/Y']
            // 'contentOptions' => ['style' => 'width:70px']
        ],



    ],
    //'export' => true,
    'panel' => [
        'type' => GridView::TYPE_SUCCESS,
        'heading' => 'Vendas Detalhadas',
        'before' => false,
        'after' => false,
        'footer' => false
    ],
]) ?>
