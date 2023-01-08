<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use app\models\financas\ItensAtivo;
use yii\db\Query;
use yii\db\Expression;
use app\models\financas\Operacao;


class DadosRecalculaAtivos
{

    private $select = [
        'itens_ativo.id as itens_ativo_id',
        'sum(operacao.quantidade) as quantidade',
        'sum(operacao.valor) as valor'
    ];
    private function query()
    {

        $dadosAtivosValores = new DadosAtivosValores();
        $quantidadeValorCompra = ItensAtivo::find()
            ->select([
                'ativo.id as ativo_id',
                'itens_ativo.id as itens_ativo_id',
                new Expression($this->selectQuantidade() . " as quantidade"),
                new Expression($this->selectValorCompra() . "as valor_compra"),
                new Expression($this->valorAtual())



            ])
            ->innerJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->leftJoin(['compra' => $this->valorCompra()], 'compra.itens_ativo_id = itens_ativo.id')
            ->leftJoin(['venda' => $this->valorVenda()], 'venda.itens_ativo_id = itens_ativo.id')
            ->leftJoin(['desdobramento_mais' => $this->desdobramentoMais()], 'desdobramento_mais.itens_ativo_id = itens_ativo.id')
            ->leftJoin(['desdobramento_menos' => $this->desdobramentoMenos()], 'desdobramento_menos.itens_ativo_id = itens_ativo.id')
            ->leftJoin(['preco' =>  $dadosAtivosValores->preco()], 'preco.ativo_id = ativo.id');

        return $quantidadeValorCompra;
    }


    public function getDados()
    {
        //$this->query();
        return $this->query()->asArray()->all();
    }



    private function valorCompra()
    {
        return   Operacao::find()
            ->select($this->select)
            ->innerJoin('itens_ativo', "itens_ativo.id = operacao.itens_ativos_id")
            ->where(['tipo' => Operacao::TipoOperacaoId()[Operacao::COMPRA]])
            ->groupBy(['itens_ativo.id']);
    }

    private function valorVenda()
    {
        return Operacao::find()
            ->select($this->select)
            ->innerJoin('itens_ativo', "itens_ativo.id = operacao.itens_ativos_id")
            ->where(['tipo' => Operacao::TipoOperacaoId()[Operacao::VENDA]])
            ->groupBy(['itens_ativo.id']);
    }


    private function desdobramentoMenos()
    {
        return  Operacao::find()
            ->select($this->select)
            ->innerJoin('itens_ativo', "itens_ativo.id = operacao.itens_ativos_id")
            ->where(['tipo' => Operacao::TipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS]])
            ->groupBy(['itens_ativo.id']);
    }


    private function desdobramentoMais()
    {
        return Operacao::find()
            ->select($this->select)
            ->innerJoin('itens_ativo', "itens_ativo.id = operacao.itens_ativos_id")
            ->where(['tipo' => Operacao::TipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS]])
            ->groupBy(['itens_ativo.id']);
    }


    private function selectQuantidade()
    {
        return "(COALESCE (compra.quantidade,0) + COALESCE (desdobramento_mais.quantidade,0) - COALESCE (venda.quantidade,0) - COALESCE(desdobramento_menos.quantidade,0))";
    }

    private function selectValorCompra()
    {
        return "(COALESCE (compra.valor,0)  - COALESCE (venda.valor,0))";
    }

    private function valorAtual(): string
    {
        return " (case  WHEN preco.valor is null THEN  itens_ativo.valor_bruto 
                         WHEN preco.valor is not null THEN (COALESCE (" . $this->selectQuantidade() . ",0) * preco.valor)
                         END) as valor_atual";
    }
}
