<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use yii\db\Expression;
use app\models\sincronizar\Preco;
use app\models\financas\ItensAtivo;
use app\models\financas\Operacao;
use yii\db\Query;

class DadosAtivosValores
{

    private function query()
    {
        return ItensAtivo::find()
            ->select([
                'ativo.id as ativo_id',
                'itens_ativo.id as itens_ativo_id',
                new Expression("itens_ativo.quantidade * preco.valor as valor"),
                'valor_compra.valor_compra',
                'ativo.pais',
            ])
            ->innerJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->innerJoin('atualiza_acao', 'atualiza_acao.ativo_id = ativo.id')
            ->innerJoin(['preco' => $this->preco()], 'preco.ativo_id = ativo.id')
            ->innerJoin(['valor_compra' => $this->valorCompra()], 'valor_compra.itens_ativo_id = itens_ativo.id')
            ->where(['ativo' => true]);
    }


    private function preco()
    {
        return  Preco::find()
            ->select([
                new Expression("distinct on(ativo_id)  ativo_id "),
                'valor',
                // 'max(data)'
            ])
            ->orderBy([
                'ativo_id' => \SORT_ASC,
                'data' => \SORT_DESC
            ]);
    }

    private function valorCompra()
    {
        $tipoOperacao = Operacao::tipoOperacaoId();
        $valorCompra = Operacao::find()
            ->select([
                'itens_ativo.id as itens_ativo_id',
                'operacao.tipo as compra',
                'sum(operacao.valor) as valor',
            ])
            ->innerJoin('itens_ativo', 'itens_ativo.id = operacao.itens_ativos_id')
            ->innerJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->innerJoin('atualiza_acao', 'atualiza_acao.ativo_id = ativo.id')
            ->where(['operacao.tipo' => $tipoOperacao[Operacao::COMPRA]])
            ->groupBy([
                'itens_ativo.id',
                'operacao.tipo'
            ]);

        $valorVendas = Operacao::find()
            ->select([
                'itens_ativo.id as itens_ativo_id',
                'operacao.tipo as venda',
                'coalesce(sum(operacao.valor),0) as valor',
            ])
            ->leftJoin('itens_ativo', 'itens_ativo.id = operacao.itens_ativos_id')
            ->leftJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->leftJoin('atualiza_acao', 'atualiza_acao.ativo_id = ativo.id')
            ->where(['operacao.tipo' => $tipoOperacao[Operacao::VENDA]])
            ->groupBy([
                'itens_ativo.id',
                'operacao.tipo'
            ]);
        return (new Query())
            ->select([
                'compra.itens_ativo_id',
                new Expression('compra.valor - coalesce(venda.valor,0) as valor_compra')
            ])
            ->from(['compra' => $valorCompra])
            ->leftJoin(['venda' => $valorVendas], 'compra.itens_ativo_id = venda.itens_ativo_id');
    }




    public function getDados()
    {
        return $this->query()->asArray()->all();
    }
}
