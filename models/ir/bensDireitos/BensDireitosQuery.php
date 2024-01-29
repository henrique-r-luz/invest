<?php

namespace app\models\ir\bensDireitos;

use app\lib\dicionario\Categoria;
use yii\db\Expression;
use app\lib\dicionario\Pais;
use app\models\financas\Operacao;

class BensDireitosQuery
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
            ->where(['investidor_id' => $this->formBensDireito->investidor_id])
            ->andWhere(new Expression(" EXTRACT(YEAR FROM  operacao.data) <='" . $this->formBensDireito->ano . "'"))
            ->andWhere(['ativo.pais' => Pais::BR])
            ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
            //->andWhere(['itens_ativo.ativo' => true])
            ->orderBy([
                'ativo.codigo' => \SORT_ASC,
                'operacao.data' => \SORT_ASC
            ])->all();

        return $operacoes;
    }
}
