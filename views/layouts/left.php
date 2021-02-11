<aside class="main-sidebar">

    <section class="sidebar">

        <!-- search form 
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
       /.search form -->

        <?=
        dmstr\widgets\Menu::widget(
                [
                    'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
                    'items' => [
                        ['label' => 'Menu', 'options' => ['class' => 'header']],
                        [
                            'label' => 'Tools',
                            'icon' => 'share',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                                ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                            ],
                        ],
                        [
                            'label' => 'Finanças',
                            'icon' => 'dollar',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Ativo', 'icon' => 'diamond', 'url' => ['/financas/ativo']],
                                ['label' => 'Atualiza Ação', 'icon' => 'undo', 'url' => ['/financas/atualiza-acao']],
                                ['label' => 'Operação', 'icon' => 'money', 'url' => ['/financas/operacao']],
                                ['label' => 'Empresas Bolsa', 'icon' => 'building', 'url' => ['/financas/acao-bolsa']],
                                // ['label' => 'Balanço', 'icon' => 'clipboard', 'url' => ['/balanco-empresa-bolsa']],
                                ['label' => 'Sincronizar', 'icon' => 'rotate-left', 'url' => ['/financas/sincronizar']],
                            ],
                        ],
                        [
                            'label' => 'Relatórios',
                            'icon' => 'file',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Filtro Empresas', 'icon' => 'filter', 'url' => ['/relatorios/analise-empresa']],
                                ['label' => 'Aporte', 'icon' => 'balance-scale', 'url' => ['/relatorios/aporte']],
                            ],
                        ],
                        [
                            'label' => 'Análise Gráfica',
                            'icon' => 'bar-chart',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Histograma', 'icon' => 'signal', 'url' => ['/analiseGrafica/histograma']],
                                ['label' => 'Correlação', 'icon' => 'exchange', 'url' => ['/']],
                                ['label' => 'Evol. Patrimônio', 'icon' => 'signal', 'url' => ['/analiseGrafica/evolucao-patrimonio']],
                                ['label' => 'Lucro/Prejuízo', 'icon' => 'signal', 'url' => ['/analiseGrafica/lucro-prejuizo']],
                            ],
                        ]
                    ],
                ]
        )
        ?>

    </section>

</aside>
