<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib;

/**
 * Description of TipoFiltro
 *
 * @author henrique
 */
class TipoFiltro {
    //put your code here
    
     const AGUIA_CONSERVADOR = 'AGUIA_CONSERVADOR';
     
     
       public static function all()
    {
        return [
            self::AGUIA_CONSERVADOR => 'AGUIA_CONSERVADOR',
           
        ];
    }
    
    /**
     * Retorna um enun baseado no seu valor
     * @param int $tipoCurso valor do tipo_curso. 
     * @return string
     */
    public static function get($tipoFiltro)
    {
        $all = self::all();

        if (isset($all[$tipoFiltro])) {
            return $all[$tipoFiltro];
        }

        return 'Não existe';
    }
    
}
