<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

/**
 * Description of GraficoAtivo
 *
 * @author henrique
 */
class GraficoAtivo extends GraficoAbstract
{

    private $ativo;

    //put your code here


    protected function configuraDados()
    {
        $this->ativo = GraficoUtil::dadosPizza([
            'dados' => $this->dados,
            'item' => 'codigo',
            'valor_item' => 'valor_bruto',
            'valor_total' => 'valor_total',
            'valorAporte' => $this->valorAporte,
            'valorInvestido' => $this->valorInvestido,
        ]);
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->ativo);
    }
}
