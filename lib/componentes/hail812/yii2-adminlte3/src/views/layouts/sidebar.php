<?php

use yii\helpers\Html; ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->

    <a href="<?php echo  \Yii::$app->homeUrl ?>" class="brand-link">
        <img src="/img/logo2.png" alt="Invest Logo" class="brand-image">
        <span class="brand-text font-weight-light">INVEST</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \app\lib\Menu::widget([
                'items' => [
                    [
                        'label' => 'Config',
                        'icon' => 'crop',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Classes Operações', 'icon' => 'sticky-note', 'url' => ['config/classes-operacoes']],
                        ],
                    ],
                    [
                        'label' => 'Finanças',
                        'icon' => 'dollar-sign',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Ativo', 'icon' => 'gem', 'url' => ['financas/ativo']],
                            ['label' => 'Investidor', 'icon' => 'user', 'url' => ['financas/investidor']],
                            ['label' => 'Ativo Investidos', 'icon' => 'glass-cheers', 'url' => ['financas/itens-ativo']],
                            ['label' => 'Operação', 'icon' => 'cash-register', 'url' => ['financas/operacao']],
                            ['label' => 'Operações Import', 'icon' => 'file-import', 'url' => ['financas/operacoes-import']],
                            ['label' => 'Proventos', 'icon' => 'arrow-down', 'url' => ['financas/proventos']],
                            ['label' => 'Empresas Bolsa', 'icon' => 'building', 'url' => ['financas/acao-bolsa']],

                        ],
                    ],

                    [
                        'label' => 'Sincronizar',
                        'icon' => 'sync-alt',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Atualiza', 'icon' => 'sync-alt', 'url' => ['sincronizar/sincronizar']],
                            ['label' => 'Atualiza Ações', 'icon' => 'chevron-circle-down', 'url' => ['sincronizar/atualiza-acoes']],
                            ['label' => 'Preço', 'icon' => 'dollar-sign', 'url' => ['sincronizar/preco']],
                            ['label' => 'Site Ação', 'icon' => 'undo', 'url' => ['sincronizar/site-acoes']],
                            ['label' => 'Ativo Manual', 'icon' => 'plus', 'url' => ['sincronizar/atualiza-ativo-manual']],
                            ['label' => 'Operação Manual', 'icon' => 'plus-square', 'url' => ['sincronizar/atualiza-operacoes-manual']],

                        ],
                    ],

                    [
                        'label' => 'Análise Gráfica',
                        'icon' => 'chart-line',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Evol. Aportes', 'icon' => 'level-up-alt', 'url' => ['analiseGrafica/evolucao-patrimonio']],
                            ['label' => 'Lucro/Prejuízo', 'icon' => 'plus-circle', 'url' => ['analiseGrafica/lucro-prejuizo']],
                            ['label' => 'Proventos/mês', 'icon' => 'file-invoice-dollar', 'url' => ['analiseGrafica/evolucao-proventos']],
                            ['label' => 'Proventos/Ativo', 'icon' => 'rocket', 'url' => ['analiseGrafica/proventos-por-ativo']],
                            ['label' => 'Proventos/ValorAtual', 'icon' => 'rocket', 'url' => ['analiseGrafica/proventos-valor-por-montante']],
                        ],
                    ],
                    [
                        'label' => 'IR',
                        'icon' => 'exclamation-triangle',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Bens Direitos', 'icon' => 'suitcase', 'url' => ['ir/bens-direitos']],
                            ['label' => 'Operações Vendas', 'icon' => 'cart-arrow-down', 'url' => ['ir/operacoes-vendas']]
                        ],
                    ],


                    [
                        'label' => 'Admin',
                        'icon' => 'hammer',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Auditoria', 'icon' => 'audio-description', 'url' => ['admin/auditoria']],
                            ['label' => 'Usuário', 'icon' => 'user', 'url' => ['admin/user']],
                        ],
                    ]
                ]
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>