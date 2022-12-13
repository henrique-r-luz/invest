<?php

namespace app\lib\helpers;

class ConvertValorMonetario
{

    public static function brParaUs($valor)
    {
        //remove pontos
        $valorConersao = str_replace('.', '', $valor);
        //troca vírgula  por ponto 
        $valorConersao = str_replace(',', '.', $valorConersao);
        return $valorConersao;
    }
    public static function usParaBr()
    {
        //remove virgula

        //troca ponto  por virgula 
    }
}
