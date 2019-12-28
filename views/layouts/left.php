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
                                ['label' => 'Tipo do ativo', 'icon' => 'list', 'url' => ['/tipo'],],
                                ['label' => 'Categoria', 'icon' => 'indent', 'url' => ['/categoria']],
                                ['label' => 'Ativo', 'icon' => 'diamond', 'url' => ['/ativo']],
                                ['label' => 'Operação', 'icon' => 'paper-plane', 'url' => ['/operacao']],
                                ['label' => 'Empresas Bolsa', 'icon' => 'building', 'url' => ['/acao-bolsa']],
                                ['label' => 'Sicronizar', 'icon' => 'rotate-left', 'url' => ['/sicronizar']],
                                ['label' => 'Aporte', 'icon' => 'balance-scale', 'url' => ['/aporte']],
                               
                            ],
                        ],
                        [
                            'label' => 'Relatórios',
                            'icon' => 'file',
                            'url' => '#',
                            'items' => [
                                ['label' => 'Aportes por tempo', 'icon' => 'balance-scale', 'url' => ['/relatorio/relatorio-aporte']],
                            ],
                        ],
                    ],
                ]
        )
        ?>

    </section>

</aside>
