<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\models\sincronizar\Preco;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;

class GetPrecoCadastrado
{
    private $itensAtivo;
    public function __construct(ItensAtivo $itensAtivo)
    {
        $this->itensAtivo = $itensAtivo;
    }


    public function getValor()
    {
        /**
         * @var Preco $precoAtivo
         */
        $precoAtivo = Preco::find()->where(['ativo_id' => $this->itensAtivo->ativo_id])
            ->orderBy(['data' => \SORT_DESC])
            ->one();
        if (empty($precoAtivo)) {
            throw new InvestException('Nenhum cadastro de preço foi encontrato para o ativo');
        }
        return $this->itensAtivo->quantidade * $precoAtivo->valor;
    }
}
