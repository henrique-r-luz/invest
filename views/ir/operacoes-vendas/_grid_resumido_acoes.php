<?php

use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $providerAcoes,
    'toolbar' => [],
    'columns' => [


        [
            'attribute' => 'valor_compra',
            'format' => 'currency',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'valor_venda',
            'format' => 'currency',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'resultado',
            'format' => 'currency',
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
        'type' => GridView::TYPE_WARNING,
        'heading' => 'Vendas Resumidas Ações',
        'before' => false,
        'after' => false,
        'footer' => false
    ],
]) ?>
