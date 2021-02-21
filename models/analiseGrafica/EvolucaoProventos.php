<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

use \app\models\financas\Proventos;
use \app\lib\Categoria;

/**
 * Description of EvolucaoProventos
 *
 * @author henrique
 */
class EvolucaoProventos {

    //put your code here

    private $dadosGrafico;
    private $dataTime;
    
    function __construct() {
        $this->evolucaoProventos();
    }

    public function evolucaoProventos() {
        $query= Proventos::find()
                ->select(["to_char(data, 'YYYY-MM') as data", 'ROUND(sum(valor)::numeric,2) as valores'])
                ->groupBy(["to_char(data, 'YYYY-MM')"])
                ->orderBy(["to_char(data, 'YYYY-MM')"=>SORT_ASC])
                ->asArray()
                ->all();
        $valores = array_column($query, 'valores');
       
        $valores = array_map('floatval', $valores);
        $this->dadosGrafico = ['name'=>'Proventos','data'=>$valores];
        $tempo = array_column($query, 'data');
        $this->dataTime = $tempo;
    }
    
   

    function getDadosGrafico() {
        return $this->dadosGrafico;
    }
    
     function getDataTime() {
        return $this->dataTime;
    }

}
