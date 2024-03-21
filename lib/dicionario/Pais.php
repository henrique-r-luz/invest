<?php


namespace app\lib\dicionario;


class Pais
{

    const BR = 'BR';
    const  US = 'US';
    /**
     * Criptomoeadas
     */
    const CR = 'CR';

    /**
     * Retorna todos os enuns em um array
     * @return array 
     */
    public static function all()
    {
        return [
            self::BR => Pais::BR,
            self::US => Pais::US,
            self::CR => Pais::CR
        ];
    }

    /**
     * Retorna um enun baseado no seu valor  
     * @return string
     */
    public static function get($pais)
    {
        $all = self::all();

        if (isset($all[$pais])) {
            return $all[$pais];
        }

        return 'Não existe';
    }
}
