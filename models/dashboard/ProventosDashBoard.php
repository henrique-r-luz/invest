<?php

namespace app\models\dashboard;

use app\lib\dicionario\Pais;
use app\lib\config\ValorDollar;
use app\models\financas\Proventos;
use yii\db\Expression;
use yii\db\Query;

class ProventosDashBoard
{

    private $queryBase;
    public function __construct($investidorId = null)
    {
        $this->queryBase =   Proventos::find()

            ->innerJoin('itens_ativo', 'itens_ativo.id = proventos.itens_ativos_id')
            ->innerjoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->andFilterWhere(['itens_ativo.investidor_id' => $investidorId]);
    }

    private function valorBR()
    {
        $query = clone $this->queryBase;
        return $query
            ->select([
                new Expression("sum(valor) as valor_br")
            ])
            ->andWhere(['ativo.pais' => Pais::BR]);
    }

    private function valorUsa()
    {
        $query = clone $this->queryBase;
        return $query
            ->select([
                new Expression("sum(valor) as valor_usa")
            ])
            ->andWhere(['ativo.pais' => Pais::US]);
    }

    public function getValor()
    {
        $query = (new Query())
            ->from(['valor_br' => $this->valorBR(), 'valor_usa' => $this->valorUsa()])
            ->one();

        return   \floatval($query['valor_br']) + \floatval(ValorDollar::convertValorMonetario($query['valor_usa'], Pais::US));
    }
}
