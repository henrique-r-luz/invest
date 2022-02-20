<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\lib\dicionario;

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
    
    
    public static function getDescricaoFiltro($tipoFiltro){
         switch ($tipoFiltro) {
             case  self::AGUIA_CONSERVADOR:
                 return self::getAguiaConservador();
         }
    } 
    
    
    private function getAguiaConservador(){
        $text = "<b> Definições do filtros:</b></br>";
        $text .="<ul>";
        $text .="<li>A empresa deve ter no mínimo 10 anos de bolsa.</li>";
        $text .="<li>O fcl_capex deve ser maior que 0.</li>";
        $text .="<li>Permite 3 fcl_capex negativos nos último 10 anos.</li>";
        $text .="<li>O lucro deve ser maior que 0.</li>";
        $text .="<li>O EBITA deve ser maior que 0.</li>";
        $text .="<li>A divida liquida por EBITA deve ser menor que 3.</li>";
        $text .="<li>A margem liquida deve ser maior que 10%.</li>";
        $text .="</ul>";
        return $text;
    }
    
}
