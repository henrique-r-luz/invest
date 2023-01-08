<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;

class ItenaAtivoAlteraCompra
{
    public static function compra(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $itensAtivo->valor_compra += $operacao->valor;
        $itensAtivo->quantidade += $operacao->quantidade;
        $itensAtivo->valor_liquido += $operacao->valor;
        $itensAtivo->valor_bruto += $operacao->valor;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }


    public static function delete(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $itensAtivo->valor_compra -= $operacao->valor;
        $itensAtivo->quantidade -= $operacao->quantidade;
        $itensAtivo->valor_liquido -= $operacao->valor;
        $itensAtivo->valor_bruto -= $operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
        DeleteOperacao::delete($operacao);
    }


    public static function update($oldOperacao, ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $itensAtivo->valor_compra += $operacao->valor  - $oldOperacao['valor'];
        $itensAtivo->quantidade += $operacao->quantidade - $oldOperacao['quantidade'];
        $itensAtivo->valor_liquido += $operacao->valor - $oldOperacao['valor'];
        $itensAtivo->valor_bruto += $operacao->valor - $oldOperacao['valor'];

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
