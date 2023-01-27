<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\config\ValorDollar;
use app\lib\dicionario\Pais;

/**
 * Description of GraficoAcaoPais
 *
 * @author henrique
 */
class GraficoAcaoPais extends GraficoAbstract
{

    private $acaoPais = [];

    //put your code here
    protected function configuraDados()
    {
        $valorTotalAcoes = 0;
        foreach ($this->dados as $item) {
            $this->acaoPais[$item['pais']] = ValorDollar::convertValorMonetario($item['valor_acao_pais'], $item['pais']);
        }

        $valorTotalAcoes = array_sum($this->acaoPais);

        if ($valorTotalAcoes != 0) {
            $aux = [];
            foreach ($this->acaoPais as $nome => $item) {
                $aux[$nome] = round(($item / $valorTotalAcoes) * 100);
            }
            $this->acaoPais = $aux;
            arsort($this->acaoPais);
        }
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->acaoPais);
    }
}
