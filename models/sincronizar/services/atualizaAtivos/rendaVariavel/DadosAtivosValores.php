<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use yii\db\Expression;
use app\models\sincronizar\Preco;
use app\models\financas\ItensAtivo;
use app\models\financas\Operacao;

/**
 * Só Atualiza renda variável
 *
 * @author Henrique Luz
 */
class DadosAtivosValores
{

    private $itensAtivo_id;

    public function __construct($itensAtivo_id)
    {
        $this->itensAtivo_id = $itensAtivo_id;
    }

    private function query()
    {
        return ItensAtivo::find()
            ->select([
                'ativo.id as ativo_id',
                'itens_ativo.id as itens_ativo_id',
                new Expression("itens_ativo.quantidade * preco.valor as valor"),
                'itens_ativo.quantidade',
                'ativo.pais',
                'preco.valor as preco'
            ])
            ->innerJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->innerJoin('site_acoes', 'site_acoes.ativo_id = ativo.id')
            ->innerJoin(['preco' => $this->preco()], 'preco.ativo_id = ativo.id')
            ->where(['ativo' => true])
            ->andFilterWhere(['itens_ativo.id' => $this->itensAtivo_id]);
    }




    public function preco()
    {
        return  Preco::find()
            ->select([
                new Expression("distinct on(ativo_id)  ativo_id "),
                'valor',
            ])
            ->orderBy([
                'ativo_id' => \SORT_ASC,
                'data' => \SORT_DESC
            ]);
    }


    public function getDados()
    {
        return $this->query();
    }
}
