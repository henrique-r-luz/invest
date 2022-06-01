<?php


namespace app\lib\dicionario;


class ProventosMovimentacao {
    
    const Dividendo = 'Dividendo';
    const  JurosSobreCapitalProprio = 'Juros Sobre Capital Próprio';
    const  Rendimento = 'Rendimento';

    /**
     * Retorna todos os enuns em um array
     * @return array 
     */
    public static function all()
    {
        return [
            1 => self::Dividendo,
            2 => self::JurosSobreCapitalProprio,
            3 => self::Rendimento,
        ];
    }
    
    /**
     * Retorna um enun baseado no seu valor  
     * @return string
     */
    public static function getNome($id)
    {
        $all = self::all();

        if (isset($all[$id])) {
            return $all[$id];
        }

        return 'Não existe';
    }

    public static function getId($nome)
    {
        $valor = array_search($nome, self::all());
        if($valor===false){
            return 'Não existe';
        }
        return $valor;
    }
}
