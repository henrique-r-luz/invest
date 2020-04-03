<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\componentes;

class Util {
    
    /**
     * convert uma string desse formato: {1,2,3},
     * em um array : [1,2,3]
     * @param String $valor
     * @return Array
     */
    public static function convertArrayAgregInVetor(String $valor) {
        $valor = str_replace(['{','}'],'',$valor);
        return explode(',', $valor);
    }

}
