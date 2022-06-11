<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\dicionario\Tipo;
use app\models\dashboard\GraficoUtil;
use app\models\dashboard\GraficoAbstract;

/**
 * Description of GraficoFiis
 *
 * @author henrique
 */
class GraficoFiis extends GraficoAbstract
{
    //put your code here

    private $fii = [];


    protected function configuraDados()
    {

        $valorTotalFii = 0;
        if (empty($this->dados)) {
            return;
        }
        foreach ($this->dados as $item) {
            if ($item['tipo'] == Tipo::FIIS) {
                $this->fii[$item['codigo']] = $item['valor_bruto'];
            }
        }
        $valorTotalFii = array_sum($this->fii);
        if ($valorTotalFii != 0) {
            $aux = [];
            foreach ($this->fii as $nome => $item) {
                $aux[$nome] = round(($item / $valorTotalFii) * 100);
            }
            $this->fii = $aux;
            arsort($this->fii);
        }
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->fii);
    }
}
