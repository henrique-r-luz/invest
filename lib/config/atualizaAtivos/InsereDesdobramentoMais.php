<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\CajuiHelper;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaItensAtivoPorData;

class InsereDesdobramentoMais
{

    public static function insere($itensAtivo, $operacao)
    {
        if (CalculaItensAtivoPorData::verificaDataOperacao($operacao)) {
            return true;
        }
        $itensAtivo->quantidade += $operacao->quantidade;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    public static function delete($itensAtivo, $operacao)
    {
        $aux = $operacao;
        DeleteOperacao::delete($aux);
        if (CalculaItensAtivoPorData::verificaDataOperacao($operacao)) {
            return true;
        }
        $itensAtivo->quantidade -= $operacao->quantidade;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    public static function update($itensAtivo, $operacao, $oldOperacao)
    {
        if (CalculaItensAtivoPorData::verificaDataOperacao($operacao)) {
            return true;
        }
        $itensAtivo->quantidade = ($itensAtivo->quantidade
            - $oldOperacao['quantidade'])
            + $operacao->quantidade;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
