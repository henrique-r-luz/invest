<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

/**
 * Description of GraficoAbstract
 *
 * @author henrique
 */
abstract class GraficoAbstract
{

    protected $dados;
    protected $valorAporte;
    protected $valorInvestido;

    function __construct($dados, $valoresTotais)
    {
        $this->dados = $dados;
        $this->valorAporte = ValoresConsolidados::valorCompra($valoresTotais);
        $this->valorInvestido = ValoresConsolidados::valorInvestido($valoresTotais);
        $this->configuraDados();
    }


    abstract protected  function configuraDados();

    abstract public function montaGrafico();
}
