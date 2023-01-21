<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\CajuiHelper;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;

class InsereDesdobramentoMenos
{

    public static function insere($itensAtivo, $operacao)
    {

        $itensAtivo->quantidade -= $operacao->quantidade;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    public static function delete($itensAtivo, $operacao)
    {
        $itensAtivo->quantidade += $operacao->quantidade;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
        DeleteOperacao::delete($operacao);
    }

    public static function update($itensAtivo, $operacao, $oldOperacao)
    {
        $itensAtivo->quantidade = ($itensAtivo->quantidade + $oldOperacao['quantidade']) - $operacao->quantidade;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
