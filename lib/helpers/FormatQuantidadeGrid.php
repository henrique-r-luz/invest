<?php

namespace app\lib\helpers;

class FormatQuantidadeGrid
{

    public static function format(string $quantidade)
    {
        $vet = explode(".", $quantidade);

        if (isset($vet[1])) {
            return number_format($quantidade, strlen($vet[1]), ',', ' ');
        }
        return $quantidade;
    }
}
