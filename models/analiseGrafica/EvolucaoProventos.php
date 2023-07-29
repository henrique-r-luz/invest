<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

use \app\lib\Categoria;
use app\lib\dicionario\Pais;
use \app\models\financas\Proventos;

/**
 * Description of EvolucaoProventos
 *
 * @author henrique
 */
class EvolucaoProventos
{

    //put your code here
    private $dadosGrafico;
    private $dataTime;

    function __construct()
    {
        $this->dadosGrafico = [];
        $this->evolucaoProventos();
    }

    public function evolucaoProventos()
    {
        $query = Proventos::find()
            ->select(['ativo.pais', "to_char(data, 'YYYY-MM') as data", 'ROUND(sum(valor)::numeric,2) as valores'])
            ->innerJoin('itens_ativo', 'itens_ativo.id = proventos.itens_ativos_id')
            ->innerjoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->groupBy(["to_char(data, 'YYYY-MM')", "ativo.pais"])
            ->orderBy(["to_char(data, 'YYYY-MM')" => SORT_ASC]);
        $dados = $query
            ->asArray()
            ->indexBy(function ($row) {
                return $row['pais'] . $row['data'];
            })
            ->all();
        $this->dataTime = (array_unique(array_column($dados, 'data')));
        $this->dataTime = array_values($this->dataTime);
        $this->mapDataPorValor($dados);
    }


    /**
     * mapeia as datas pelos valores de cada mês
     *
     * @return void
     * @author Henrique Luz
     */
    private function  mapDataPorValor($dados)
    {
        $usa =  $this->ativosUsa($dados);
        $br =  $this->ativosBr($dados);
        $id = 0;
        $vetBr = [];
        $vetUs = [];

        foreach ($this->dataTime as $data) {
            if (isset($br[Pais::BR . $data])) {
                $vetBr[$id] = floatval($br[Pais::BR . $data]['valores']);
            } else {
                $vetBr[$id] = 0;
            }
            if (isset($usa[Pais::US . $data])) {
                $vetUs[$id] = floatval($usa[Pais::US . $data]['valores']);
            } else {
                $vetUs[$id] = 0;
            }
            $id++;
        }
        $this->dadosGrafico[] = ['name' => 'Real', 'data' => $vetBr];
        $this->dadosGrafico[] = ['name' => 'Dollar', 'data' => $vetUs];
    }



    private function ativosBr($dados)
    {
        $vetUsa =  array_filter($dados, function ($item, $key) {
            return ($item['pais'] === Pais::BR);
        }, ARRAY_FILTER_USE_BOTH);
        return $vetUsa;
    }

    private function ativosUsa($dados)
    {

        $vetBr =  array_filter($dados, function ($item, $key) {
            return ($item['pais'] === Pais::US);
        }, ARRAY_FILTER_USE_BOTH);
        return $vetBr;
    }


    public function getDadosGrafico()
    {

        return $this->dadosGrafico;
    }

    public function getDataTime()
    {
        return $this->dataTime;
    }
}
