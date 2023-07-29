<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

use \yii\base\Model;
use \app\models\financas\Operacao;
use \yii\db\Query;
use \yii\db\Expression;
use \app\lib\dicionario\Pais;

/**
 * Description of EvolucaoPatrimonio
 *
 * @author henrique
 */
class EvolucaoPatrimonio extends Model
{

    private $dadosGrafico;
    private $dataTime;

    public function getDados()
    {

        $this->dadosGrafico = [
            $this->getPatrimonioValorMoeda(Pais::BR, 'Real'),
            $this->getPatrimonioValorMoeda(Pais::US, 'Dolar')
        ];
    }

    private function getPatrimonioValorMoeda($pais, $moeda)
    {
        $dados = $this->evolucaoPratrimonio($pais);

        $patromonio = ['name' => $moeda, 'data' => []];
        $valores = [];
        $datas = array_column($dados, 'data_id');
        $this->dataTime = $datas;
        $valorPatrimonio = array_column($dados, 'valor');

        foreach ($valorPatrimonio as $id => $valorMes) {
            $sub = array_slice($valorPatrimonio, 0, ($id + 1));

            $valores[] = floatval(round(array_sum($sub), 2));
        }
        $patromonio['data'] = $valores;
        return $patromonio;
    }

    private function evolucaoPratrimonio($pais)
    {

        $comprasMes = Operacao::find()
            ->select(["to_char(data, 'YYYY-MM') as data_id", 'sum(valor) as valor_compra', 'ativo.pais'])
            ->innerJoin('itens_ativo', 'itens_ativo.id = operacao.itens_ativos_id')
            ->innerJoin('ativo', 'itens_ativo.ativo_id = ativo.id')
            ->where(['operacao.tipo' => Operacao::getTipoOperacaoId(Operacao::COMPRA)])
            ->andWhere(['ativo.pais' => $pais])
            ->andWhere(['ativo' => true])
            ->groupBy(["to_char(data, 'YYYY-MM'),ativo.pais"]);

        $vendaMes = Operacao::find()
            ->select(["to_char(data, 'YYYY-MM') as data_id", 'sum(valor) as valor_venda', 'ativo.pais'])
            ->innerJoin('itens_ativo', 'itens_ativo.id = operacao.itens_ativos_id')
            ->innerJoin('ativo', 'itens_ativo.ativo_id = ativo.id')
            ->where(['operacao.tipo' => Operacao::getTipoOperacaoId(Operacao::VENDA)])
            ->andWhere(['ativo.pais' => $pais])
            ->andWhere(['ativo' => true])
            ->groupBy(["to_char(data, 'YYYY-MM'),ativo.pais"]);

        $datasOperacao = Operacao::find()
            ->select(["to_char(data, 'YYYY-MM') as data_id"])
            ->innerJoin('itens_ativo', 'itens_ativo.id = operacao.itens_ativos_id')
            ->innerJoin('ativo', 'itens_ativo.ativo_id = ativo.id')
            ->andWhere(['ativo' => true])
            ->distinct();

        return (new Query())
            ->from(['datasOperacao' => $datasOperacao])
            ->select(['datasOperacao.data_id', '(coalesce(valor_compra, 0)  - coalesce(valor_venda, 0)) as valor'])
            ->leftJoin(['comprasMes' => $comprasMes], '"comprasMes"."data_id" = "datasOperacao"."data_id"')
            ->leftJoin(['vendaMes' => $vendaMes], '"vendaMes"."data_id" = "datasOperacao"."data_id"')
            ->orderBy(['datasOperacao.data_id' => SORT_ASC])
            ->all();
    }
    function getDadosGrafico()
    {

        return $this->dadosGrafico;
    }

    function getDataTime()
    {
        return $this->dataTime;
    }
}
