<?php

namespace app\models\dashboard;

use app\lib\config\ValorDollar;
use app\lib\dicionario\Pais;

class ValoresConsolidados
{
    public static function valorCompra($dados)
    {

        $usCompra = 0;
        foreach ($dados as $dado) {
            $usCompra += ValorDollar::convertValorMonetario($dado['valor_compra'], $dado['pais']);
        }
        return $usCompra;
    }

    public static function valorInvestido($dados)
    {


        $usLucro =  0;
        foreach ($dados as $dado) {
            $usLucro += ValorDollar::convertValorMonetario($dado['valor_total'], $dado['pais']);
        }

        return $usLucro;
    }
}
