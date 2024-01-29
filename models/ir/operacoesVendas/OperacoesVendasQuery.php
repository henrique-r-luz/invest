<?php

namespace app\models\ir\operacoesVendas;

use yii\db\Expression;
use app\lib\dicionario\Pais;
use app\lib\dicionario\Categoria;
use app\models\financas\Operacao;
use app\models\ir\bensDireitos\FormBensDireitos;

class OperacoesVendasQuery
{
    private FormBensDireitos $formBensDireito;

    public function __construct(FormBensDireitos $formBensDireito)
    {
        $this->formBensDireito = $formBensDireito;
    }

    public function query()
    {
        if (empty($this->formBensDireito->ano)) {
            return [];
        }
        $operacoes = Operacao::find()
            ->innerJoinWith(['itensAtivo.ativos'])
            ->innerJoin(['operacoes_vendidas' => $this->operacoesVendidas()], 'operacoes_vendidas.id = itens_ativo.id')
            ->where(['investidor_id' => $this->formBensDireito->investidor_id])
            ->andWhere(new Expression(" EXTRACT(YEAR FROM  operacao.data) <='" . $this->formBensDireito->ano . "'"))
            ->andWhere(['ativo.pais' => Pais::BR])
            ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
            ->orderBy([
                'ativo.codigo' => \SORT_ASC,
                'operacao.data' => \SORT_ASC
            ])->all();
        return $operacoes;
    }


    private function operacoesVendidas()
    {
        $operacoesVendidas = Operacao::find()
            ->select(['itens_ativo.id'])
            ->innerJoinWith(['itensAtivo.ativos'])
            ->where(['investidor_id' => $this->formBensDireito->investidor_id])
            ->andWhere(new Expression(" EXTRACT(YEAR FROM  operacao.data) ='" . $this->formBensDireito->ano . "'"))
            ->andWhere(['ativo.pais' => Pais::BR])
            ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
            ->andWhere(['operacao.tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA]]);

        return $operacoesVendidas;
    }
}
