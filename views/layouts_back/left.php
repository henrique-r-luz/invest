<aside class="main-sidebar">

    <section class="sidebar">


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
                                ['label' => 'Ativo Investidos', 'icon' => 'diamond', 'url' => ['/financas/itens-ativo']],
                                ['label' => 'Operações Import', 'icon' => 'refresh', 'url' => ['/financas/operacoes-import']],
                                ['label' => 'Atualiza Ação', 'icon' => 'undo', 'url' => ['/financas/atualiza-acao']],
                                ['label' => 'Investidor', 'icon' => 'user', 'url' => ['/financas/investidor']],
                                ['label' => 'Operação', 'icon' => 'money', 'url' => ['/financas/operacao']],
                                ['label' => 'Proventos', 'icon' => 'arrow-down', 'url' => ['/financas/proventos']],
                                ['label' => 'Empresas Bolsa', 'icon' => 'building', 'url' => ['/financas/acao-bolsa']],
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
                                ['label' => 'Evol. Patrimônio', 'icon' => 'line-chart', 'url' => ['/analiseGrafica/evolucao-patrimonio']],
                                ['label' => 'Lucro/Prejuízo', 'icon' => 'plus', 'url' => ['/analiseGrafica/lucro-prejuizo']],
                                ['label' => 'Proventos/mês', 'icon' => 'level-down', 'url' => ['/analiseGrafica/evolucao-proventos']],
                                ['label' => 'Proventos/Ativo', 'icon' => 'rocket', 'url' => ['/analiseGrafica/proventos-por-ativo']],
                            ],
                        ]
                    ],
                ]
        )
        ?>

    </section>

</aside>
