<?php

use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $provider,
    'toolbar' => [],
    'columns' => [
        [
            'label' => 'Código',
            'attribute' => 'codigo',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Quantidade',
            'attribute' => 'quantidade_vendida',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Preco Medio',
            'attribute' => 'preco_medio',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Valor Compra',
            'attribute' => 'valor_compra',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => 'Valor Venda',
            'attribute' => 'valor_venda',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'resultado',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'tipo',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'pais',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'data',
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
