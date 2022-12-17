<?php

namespace app\models\dashboard;

use app\lib\config\ValorDollar;
use app\lib\dicionario\Pais;

class ValoresConsolidados
{
    public static function valorCompra($dados)
    {
        /* echo '<pre>';
        print_r($dados);
        exit();*/
        $usCompra = 0;
        foreach ($dados as $dado) {
            if ($dado['pais'] == Pais::US) {
                $usCompra +=  $dado['valor_compra'] * ValorDollar::getCotacaoDollar();
            } else {
                $usCompra += $dado['valor_compra'];
            }
        }
        return $usCompra;
    }

    public static function valorInvestido($dados)
    {

            /*echo '<pre>';
        print_r($dados);
        exit()*/;
        $usLucro =  0;
        foreach ($dados as $dado) {
            if ($dado['pais'] == Pais::US) {
                $usLucro +=  $dado['valor_total'] * ValorDollar::getCotacaoDollar();
            } else {
                $usLucro +=  $dado['valor_total'];
            }
        }

        return $usLucro;
    }
}
