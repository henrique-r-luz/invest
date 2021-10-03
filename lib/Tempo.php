<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib;

/**
 * Description of Tempo
 *
 * @author henrique
 */
class Tempo {
    //put your code here
    
     
    const ANO = 'Ano';
    const  TRIMESTRE = 'Trimestre';
    
    
    public static function all()
    {
        return [
            self::ANO => self::ANO,
            self::TRIMESTRE => self::TRIMESTRE,
        ];
    }
    
    /**
     * Retorna um enun baseado no seu valor  
     * @return string
     */
    public static function get($tipo)
    {
        $all = self::all();

        if (isset($all[$tipo])) {
            return $all[$tipo];
        }

        return 'Não existe';
    }
}
