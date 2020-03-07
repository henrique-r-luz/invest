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

/**
 * Description of Modalidade
 *
 * @author Nelson Cavalcante
 * @since     1.2.2
 */
class Categoria {
    
    const RENDA_FIXA = 'Renda Fixa';
    const  RENDA_VARIAVEL = 'Renda Variável';

    /**
     * Retorna todos os enuns em um array
     * @return array 
     */
    public static function all()
    {
        return [
            self::RENDA_FIXA => 'Renda Fixa',
            self::RENDA_VARIAVEL => 'Renda Variável',
        ];
    }
    
    /**
     * Retorna um enun baseado no seu valor
     * @param int $modalidade valor do tipo. 
     * @return string
     */
    public static function get($categoria)
    {
        $all = self::all();

        if (isset($all[$categoria])) {
            return $all[$categoria];
        }

        return 'Não existe';
    }
}
