<?php

class ItensMenu
{

    public static function Itens()
    {
        $vet = [
            [
                [
                    'label' => 'Tools',
                    'icon' => 'share',
                    //'url' => '#',
                    'items' => [
                        ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                        ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ],
                ],
                [
                    'label' => 'Finanças',
                    'icon' => 'dollar-sign',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Ativo', 'icon' => 'gem', 'url' => ['/financas/ativo'], 'active' => $ativo],
                        ['label' => 'Ativo Investidos', 'icon' => 'glass-cheers', 'url' => ['/financas/itens-ativo'], 'active' => $Ativo_Investidos],
                        ['label' => 'Operações Import', 'icon' => 'file-import', 'url' => ['/financas/operacoes-import'], 'active' => $Operacoes_Import],
                        ['label' => 'Investidor', 'icon' => 'user', 'url' => ['/financas/investidor'], 'active' => $Investidor],
                        ['label' => 'Operação', 'icon' => 'cash-register', 'url' => ['/financas/operacao'], 'active' => $Operação],
                        ['label' => 'Proventos', 'icon' => 'arrow-down', 'url' => ['/financas/proventos'], 'active' => $ativo],
                        ['label' => 'Empresas Bolsa', 'icon' => 'building', 'url' => ['/financas/acao-bolsa'], 'active' => $ativo],
                        ['label' => 'Sincronizar', 'icon' => 'sync-alt', 'url' => ['/financas/sincronizar'], 'active' => $ativo],
                    ],
                ],
                [
                    'label' => 'Relatórios',
                    'icon' => 'file',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Filtro Empresas', 'icon' => 'filter', 'url' => ['/relatorios/analise-empresa'], 'active' => $ativo],
                        ['label' => 'Aporte', 'icon' => 'balance-scale', 'url' => ['/relatorios/aporte'], 'active' => $ativo],
                    ],
                ],
                [
                    'label' => 'Análise Gráfica',
                    'icon' => 'chart-line',
                    'url' => '#',
                    'items' => [
                        ['label' => 'Histograma', 'icon' => 'chart-bar', 'url' => ['/analiseGrafica/histograma'], 'active' => $Histograma],
                        ['label' => 'Correlação', 'icon' => 'project-diagram', 'url' => ['/'], 'active' => $Correlacao],
                        ['label' => 'Evol. Patrimônio', 'icon' => 'level-up-alt', 'url' => ['/analiseGrafica/evolucao-patrimonio'], 'active' => $Evol_Patrimônio],
                        ['label' => 'Lucro/Prejuízo', 'icon' => 'plus-circle', 'url' => ['/analiseGrafica/lucro-prejuizo'], 'active' => $Lucro_Prejuizo],
                        ['label' => 'Proventos/mês', 'icon' => 'file-invoice-dollar', 'url' => ['/analiseGrafica/evolucao-proventos'], 'active' => $Proventos_mes],
                        ['label' => 'Proventos/Ativo', 'icon' => 'rocket', 'url' => ['/analiseGrafica/proventos-por-ativo'], 'active' => $Proventos_Ativo],
                    ],
                ]
            ]
        ];
        return $vet;
    }
}
