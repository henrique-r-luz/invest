<?php

namespace app\lib\helpers;

use app\lib\dicionario\Pais;

class TipoMoeda
{
    public static  function valor($pais, $valor)
    {
        if (isset($pais)) {
            $valor = 'Valor($ Dollar)';
            if ($pais == Pais::BR) {
                $valor = 'Valor(R$ Real)';
            }
        }
        return $valor;
    }
}
