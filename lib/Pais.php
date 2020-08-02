<?php


namespace app\lib;


class Pais {
    
    const BR = 'BR';
    const  US = 'US';

    /**
     * Retorna todos os enuns em um array
     * @return array 
     */
    public static function all()
    {
        return [
            self::BR => 'BR',
            self::US => 'US',
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
