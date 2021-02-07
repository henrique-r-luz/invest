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

class Tipo {

    const TESOURO_DIRETO = 'Tesouro Direto';
    const FUNDOS_INVESTIMENTO = 'Fundos de Investimentos';
    const CDB = 'CDB';
    const DEBENTURES = 'Debêntures';
    const ACOES = 'Ações';
    const Criptomoeda = 'Criptomoeda';
    const OURO = 'Ouro';
    const PRATA = 'Prata';
    const ETFS = 'ETFs';
    

    /**
     * Retorna todos os enuns em um array
     * @return array 
     */
    public static function all() {
        return [
            self::TESOURO_DIRETO => 'Tesouro Direto',
            self::FUNDOS_INVESTIMENTO => 'Fundos de Investimentos',
            self::CDB => 'CDB',
            self::DEBENTURES => 'Debêntures',
            self::ACOES => 'Ações',
            self::Criptomoeda => 'Criptomoeda',
            self::OURO => 'Ouro',
            self::PRATA => 'Prata',
            self::ETFS => 'ETFs',
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
