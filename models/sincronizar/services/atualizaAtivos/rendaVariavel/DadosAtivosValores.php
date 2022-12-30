<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use yii\db\Expression;
use app\models\sincronizar\Preco;
use app\models\financas\ItensAtivo;


class DadosAtivosValores
{

    private function query()
    {
        return ItensAtivo::find()
            ->select([
                'ativo.id as ativo_id',
                'itens_ativo.id as itens_ativo_id',
                new Expression("itens_ativo.quantidade * preco.valor as valor"),
                'ativo.pais',
            ])
            ->innerJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->innerJoin('atualiza_acao', 'atualiza_acao.ativo_id = ativo.id')
            ->innerJoin(['preco' => $this->preco()], 'preco.ativo_id = ativo.id')
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


    public function getDados()
    {
        return $this->query()->asArray()->all();
    }
}
