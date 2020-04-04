<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\componentes;

class Util {

    const NUMERADOR = [
        'patrimonio_liquido'=>29,
        'receita_liquida'=>27,
        'ebitda'=>22,
        'da'=>13,
        'ebit'=>26,
        'margem_ebit'=>23,
        'resultado_financeiro'=>14,
        'lucro_liquido'=>38,
        'margem_liquida'=>30,
        'roe'=>28,
        'caixa'=>24,
        'fco'=>21,
        'capex'=>19,
        'fcl'=>16,
        'fcf'=>-20,
        'fcl_capex'=>12,
        'proventos'=>10,
        'payout'=>9,
        'indice_basileia'=>17,
    ];
    
    const DENOMINADOR = [
       
        'imposto'=>15,
        'divida_bruta'=>25,
        'pdd'=>18,
        'pdd_lucro_liquido'=>17,
        'indice_basileia'=>15,
    ];

    /**
     * convert uma string desse formato: {1,2,3},
     * em um array : [1,2,3]
     * @param String $valor
     * @return Array
     */
    public static function convertArrayAgregInVetor(String $valor) {
        $valor = str_replace(['{', '}'], '', $valor);
        $valor = str_replace('NULL', 0, $valor);
        return explode(',', $valor);
    }

}
