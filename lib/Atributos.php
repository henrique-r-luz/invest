<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib;

/**
 * Description of Atributos
 *
 * @author henrique
 */
class Atributos {
    //put your code here
    
    public static function all()
    {
        return [
       
            'patrimonio_liquido' => 'Pat. Líq.',
            'receita_liquida' => 'Re. Líq',
            'ebitda' => 'Ebitda',
            'da' => 'Da',
            'ebit' => 'Ebit',
            'margem_ebit' => 'Mar. Ebit',
            'resultado_financeiro' => 'R. Fin.',
            'imposto' => 'Imp.',
            'lucro_liquido' => 'L. Líq.',
            'margem_liquida' => 'Mar. Líq.',
            'roe' => 'Roe',
            'caixa' => 'Caixa',
            'divida_bruta' => 'D. Bruta',
            'divida_liquida' => 'D. Líq.',
            'divida_bruta_patrimonio' => 'D/ Pat.',
            'divida_liquida_ebitda' => 'D.L./ Ebitda',
            'fco' => 'Fco',
            'capex' => 'Capex',
            'fcf' => 'Fcf',
            'fcl' => 'Fcl',
            'fcl_capex' => 'Fcl_Capex',
            'proventos' => 'Prov.',
            'payout' => 'Payout',
            'pdd' => 'Pdd',
            'pdd_lucro_liquido' => 'PDD/L. Líquido',
            'indice_basileia' => 'Basiléia',
        ];
    }
    
    public static function get($tipo)
    {
        $all = self::all();

        if (isset($all[$tipo])) {
            return $all[$tipo];
        }

        return 'Não existe';
    }
}
