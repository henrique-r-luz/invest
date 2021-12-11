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
                ->innerJoin('itens_ativo','itens_ativo.id = proventos.itens_ativos_id')
                ->innerjoin('ativo','ativo.id = itens_ativo.ativo_id')
                ->where(['ativo.pais'=> \app\lib\Pais::BR])
                ->groupBy(["to_char(data, 'YYYY-MM')"])
                ->orderBy(["to_char(data, 'YYYY-MM')"=>SORT_ASC])
                ->asArray()
                ->all();
        $valores = array_column($query, 'valores');
        // tem que adicionar o valor em dollar
        $valores = array_map('floatval', $valores);
        $this->dadosGrafico = ['name'=>'Reais','data'=>$valores];
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
