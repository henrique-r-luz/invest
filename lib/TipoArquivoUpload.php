<?php

/**
 * Este arquivo é parte do
 *    ___       _       _
 *   / __\__ _ (_)_   _(_)
 *  / /  / _` || | | | | |
 * / /__| (_| || | |_| | |
 * \____/\__,_|/ |\__,_|_|
 *           |__/
 *                 Um sistema integrado do IFNMG
 * PHP version 7
 *
 * @copyright Copyright (c) 2016, IFNMG
 * @license   http://cajui.ifnmg.edu.br/license/ MIT License
 * @link      http://cajui.ifnmg.edu.br/
 */

namespace app\lib;

class TipoArquivoUpload {

    const CLEAR_R_V = 'Tesouro Direto';
    const AVENUE_R_V = 'Fundos de Investimentos';
    
    

    /**
     * Retorna todos os enuns em um array
     * @return array 
     */
    public static function all() {
        return [
            self::CLEAR_R_V => self::CLEAR_R_V,
            self::AVENUE_R_V => self::AVENUE_R_V,
           
        ];
    }

    /**
     * Retorna um enun baseado no seu valor
     * @param int $modalidade valor do tipo. 
     * @return string
     */
    public static function get($tipo) {
        $all = self::all();

        if (isset($all[$tipo])) {
            return $all[$tipo];
        }

        return 'Não existe';
    }

}
