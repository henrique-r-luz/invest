<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\dicionario\Tipo;
use app\lib\config\ValorDollar;
use app\lib\dicionario\Pais;
use app\models\dashboard\GraficoUtil;
use app\models\dashboard\GraficoAbstract;

/**
 * Description of GraficoAcoes
 *
 * @author henrique
 */
class GraficoAcoes extends GraficoAbstract
{

    private $acoes = [];

    //put your code here
    protected function configuraDados()
    {
        $valorTotalAcoes = 0;
        if (empty($this->dados)) {
            return;
        }
        foreach ($this->dados as $item) {
            if ($item['tipo'] == Tipo::ACOES) {
                $this->acoes[$item['codigo']] = ValorDollar::convertValorMonetario($item['valor_bruto'], $item['pais']);
            }
        }
        $valorTotalAcoes = array_sum($this->acoes);
        if ($valorTotalAcoes != 0) {
            $aux = [];
            foreach ($this->acoes as $nome => $item) {
                $aux[$nome] = round(($item / $valorTotalAcoes) * 100);
            }
            $this->acoes = $aux;
            arsort($this->acoes);
        }
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->acoes);
    }
}
