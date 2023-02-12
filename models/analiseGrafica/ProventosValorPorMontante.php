<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

use app\lib\config\ValorDollar;
use app\lib\dicionario\Categoria;
use app\models\financas\Proventos;

/**
 * Description of LucroPrezuijo
 *
 * @author henrique
 */
class ProventosValorPorMontante
{
    const azul = '#2748eb';
    const vermelho = '#d70026';


    public function getDadosProventosValorPorMontante()
    {
        $ativos = Proventos::find()
            ->select([
                'itens_ativos_id',
                'ativo.codigo',
                'investidor.nome',
                'round(sum(valor)::numeric,2) as valor_proventos',
                'max(itens_ativo.valor_bruto) as valor_bruto',
                'pais'
            ])
            ->innerjoin('itens_ativo', 'itens_ativo.id = proventos.itens_ativos_id')
            ->innerjoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->innerjoin('investidor', 'investidor.id = itens_ativo.investidor_id')
            ->where(['ativo' => true])
            ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
            ->groupBy(['itens_ativos_id', 'ativo.codigo', 'investidor.nome', 'pais'])
            ->orderBy(['sum(valor)' => SORT_DESC])
            ->asArray()
            ->all();

        return $this->criaDadosGrafico($ativos);
    }

    public function criaDadosGrafico($ativos)
    {
        $dados = ['name' => 'Ativos', 'data' => []];
        foreach ($ativos as $ativo) {
            $proventoPorValorBruto = round($ativo['valor_proventos'] / $ativo['valor_bruto'], 3);
            $cor = self::azul;
            $dados['data'][] = ['name' => $ativo['codigo'] . ' | ' . $ativo['nome'], 'y' => $proventoPorValorBruto, 'color' => $cor];
        }
        $auxSort =  $dados['data'];
        $y  = array_column($auxSort, 'y');
        array_multisort($y, \SORT_DESC, $auxSort);
        $dados['data'] = $auxSort;
        return $dados;
    }
}
