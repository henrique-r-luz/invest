<?php

namespace app\models\analiseGrafica;

use app\models\financas\ItensAtivo;
use app\models\financas\Proventos;

class EvolucaoProventosAtivos
{
    private $itensAtivo;
    private $dataTime = [];
    private $dadosGrafico = [['name' => 'Proventos', 'data' => []]];

    public function __construct(ItensAtivo $itensAtivo)
    {
        $this->itensAtivo = $itensAtivo;
    }

    public function getProvider()
    {
        if ($this->itensAtivo->id == null) {
            return [];
        }
        $proventos = Proventos::find()
            ->select(["to_char(proventos.data, 'YYYY-MM') as data", 'ROUND(sum(proventos.valor)::numeric,2) as valores'])
            ->innerJoin(ItensAtivo::tableName(), 'proventos.itens_ativos_id = itens_ativo.id')
            ->where(['itens_ativo.id' => $this->itensAtivo->id])
            ->groupBy(["to_char(proventos.data, 'YYYY-MM')"])
            ->orderBy(['data' => SORT_ASC])
            ->asArray()
            ->limit(60)->all();
        $this->dataTime = array_column($proventos, 'data');
        foreach ($proventos as $provento) {
            $this->dadosGrafico[0]['data'][] = floatval($provento['valores']);
        }
        //$this->dadosGrafico[0]['data'] = array_values(array_column($proventos, 'valores'));
    }

    public function getDataTime()
    {
        return $this->dataTime;
    }

    public function getDadosGrafico()
    {
        return $this->dadosGrafico;
    }
}
