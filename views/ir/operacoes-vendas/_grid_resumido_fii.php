<?php

use kartik\grid\GridView;
?>

<?= GridView::widget([
    'dataProvider' => $providerFii,
    'toolbar' => [],
    'columns' => [


        [
            'attribute' => 'valor_compra',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'valor_venda',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'attribute' => 'resultado',
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
        'heading' => 'Vendas Resumidas FIIS',
        'before' => false,
        'after' => false,
        'footer' => false
    ],
]) ?>
