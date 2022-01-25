<?php use yii\helpers\Html; ?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    
    <a href="<?php echo  \Yii::$app->homeUrl?>" class="brand-link">
        <img src="/img/logo2.png" alt="Invest Logo" class="brand-image" >
        <span class="brand-text font-weight-light">INVEST</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) 
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= $assetDir ?>/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        -->
        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \app\lib\Menu::widget([
                'items' => [
                    [
                        'label' => 'Finanças',
                        'icon' => 'dollar-sign',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Ativo', 'icon' => 'gem', 'url' => ['financas/ativo']],
                            ['label' => 'Ativo Investidos', 'icon' => 'glass-cheers', 'url' => ['financas/itens-ativo']],
                            ['label' => 'Atualiza Ação', 'icon' => 'undo', 'url' => ['financas/atualiza-acao']],
                            ['label' => 'Investidor', 'icon' => 'user', 'url' => ['financas/investidor']],
                            ['label' => 'Operação', 'icon' => 'cash-register', 'url' => ['financas/operacao']],
                            ['label' => 'Operações Import', 'icon' => 'file-import', 'url' => ['financas/operacoes-import']],
                            ['label' => 'Proventos', 'icon' => 'arrow-down', 'url' => ['financas/proventos']],
                            ['label' => 'Empresas Bolsa', 'icon' => 'building', 'url' => ['financas/acao-bolsa']],
                            ['label' => 'Sincronizar', 'icon' => 'sync-alt', 'url' => ['financas/sincronizar']],
                        ],
                    ],
                   /* [
                        'label' => 'Relatórios',
                        'icon' => 'file',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Filtro Empresas', 'icon' => 'filter', 'url' => ['relatorios/analise-empresa']],
                            ['label' => 'Aporte', 'icon' => 'balance-scale', 'url' => ['relatorios/aporte']],
                        ],
                    ],*/
                    [
                        'label' => 'Análise Gráfica',
                        'icon' => 'chart-line',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Histograma', 'icon' => 'chart-bar', 'url' => ['analiseGrafica/histograma']],
                            ['label' => 'Correlação', 'icon' => 'project-diagram', 'url' => ['/']],
                            ['label' => 'Evol. Patrimônio', 'icon' => 'level-up-alt', 'url' => ['analiseGrafica/evolucao-patrimonio']],
                            ['label' => 'Lucro/Prejuízo', 'icon' => 'plus-circle', 'url' => ['analiseGrafica/lucro-prejuizo']],
                            ['label' => 'Proventos/mês', 'icon' => 'file-invoice-dollar', 'url' => ['analiseGrafica/evolucao-proventos']],
                            ['label' => 'Proventos/Ativo', 'icon' => 'rocket', 'url' => ['analiseGrafica/proventos-por-ativo']],
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