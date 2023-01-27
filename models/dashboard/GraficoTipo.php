<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\config\ValorDollar;
use app\lib\dicionario\Tipo;
use app\models\dashboard\GraficoUtil;
use app\models\dashboard\GraficoAbstract;

/**
 * Description of GraficoTipo
 *
 * @author henrique
 */
class GraficoTipo extends GraficoAbstract
{

    //put your code here

    private $tipos = [];

    protected function configuraDados()
    {
        $tipo = array_unique(array_column($this->dados, 'tipo'));
        $this->tipos = GraficoUtil::dadosPizza([
            'dados' => $this->dados,
            'item' => 'tipo',
            'valor_item' => 'valor_tipo',
            'valor_total' => 'valor_total',
            'valorAporte' => $this->valorAporte,
            'valorInvestido' => $this->valorInvestido,
        ]);

        unset($this->tipos['Ações']);

        foreach ($this->dados as $dados) {
            if ($dados['tipo'] == Tipo::ACOES) {
                if ($this->valorInvestido > 0) {
                    $this->tipos['Ações-' . $dados['pais']] = round((ValorDollar::convertValorMonetario($dados['valor_acao_pais'], $dados['pais']) / $this->valorInvestido) * 100);
                }
            }
        }
        asort($this->tipos);
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->tipos);
    }
}
