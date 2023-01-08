<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\DadosRecalculaAtivos;

class RecalculaAtivos
{
    private DadosRecalculaAtivos $dados;

    public function __construct()
    {
        $this->dados = new DadosRecalculaAtivos();
    }
    public function alteraIntesAtivo()
    {
        $dados = $this->dados->getDados();
        foreach ($dados as $itemAtualiza) {
            $itemAtivo = ItensAtivo::findOne($itemAtualiza['itens_ativo_id']);
            $valor = $itemAtualiza['valor_atual'];
            $itemAtivo->valor_bruto = $valor;
            $itemAtivo->valor_liquido = $valor;
            $itemAtivo->quantidade = $itemAtualiza['quantidade'];
            $itemAtivo->valor_compra = $itemAtualiza['valor_compra'];
            if (!$itemAtivo->save()) {
                $erro = CajuiHelper::processaErros($itemAtivo->getErrors());
                throw new InvestException($erro);
            }
        }
    }
}
