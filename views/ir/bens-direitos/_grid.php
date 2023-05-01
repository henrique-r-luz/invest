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
            'attribute' => 'quantidade',
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [
            'label' => $formBensDireitos->anoAterior(),
            'format' => 'currency',
            'attribute' => 'valor_ano_anterior',
            'value' => function ($model) {
                return round($model['valor_ano_anterior'], 2);
            }
            // 'contentOptions' => ['style' => 'width:70px']
        ],
        [

            'label' => $formBensDireitos->anoAtual(),
            'format' => 'currency',
            'attribute' => 'valor_ano_atual',
            'value' => function ($model) {
                return round($model['valor_ano_atual'], 2);
            }
            // 'contentOptions' => ['style' => 'width:70px']
        ],



    ],
    //'export' => true,
    'panel' => [
        'type' => GridView::TYPE_ACTIVE,
        'heading' => 'Ativos',
        'before' => false,
        'after' => false,
        'footer' => false
    ],
]) ?>
