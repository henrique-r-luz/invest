<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\sincronizar\Preco;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;
use app\lib\config\atualizaAtivos\rendaVariavel\GetPrecoCadastrado;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaItensAtivoPorData;

class ItenaAtivoAlteraCompra
{
    public static function compra(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        if (CalculaItensAtivoPorData::verificaDataOperacao($operacao)) {
            return true;
        }
        $itensAtivo->valor_compra += $operacao->valor;
        $itensAtivo->quantidade += $operacao->quantidade;
        $getPrecoCadastrado = new GetPrecoCadastrado($itensAtivo);
        $valorFinalAtivo = $getPrecoCadastrado->getValor();
        $itensAtivo->valor_liquido = $valorFinalAtivo;
        $itensAtivo->valor_bruto = $valorFinalAtivo;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }


    public static function delete(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $aux = $operacao;
        DeleteOperacao::delete($aux);
        if (CalculaItensAtivoPorData::verificaDataOperacao($operacao)) {
            return true;
        }
        $itensAtivo->valor_compra -= $operacao->valor;
        $itensAtivo->quantidade -= $operacao->quantidade;
        $getPrecoCadastrado = new GetPrecoCadastrado($itensAtivo);
        $valorFinalAtivo = $getPrecoCadastrado->getValor();
        $itensAtivo->valor_liquido = $valorFinalAtivo;
        $itensAtivo->valor_bruto = $valorFinalAtivo;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }


    public static function update($oldOperacao, ItensAtivo $itensAtivo, Operacao $operacao)
    {
        if (CalculaItensAtivoPorData::verificaDataOperacao($operacao)) {
            return true;
        }
        $itensAtivo->valor_compra = ($itensAtivo->valor_compra - $oldOperacao['valor']) + $operacao->valor; //$operacao->valor  - $oldOperacao['valor'];
        $itensAtivo->quantidade = ($itensAtivo->quantidade - $oldOperacao['quantidade']) + $operacao->quantidade;
        $getPrecoCadastrado = new GetPrecoCadastrado($itensAtivo);
        $valorFinalAtivo = $getPrecoCadastrado->getValor();
        $itensAtivo->valor_liquido = $valorFinalAtivo;
        $itensAtivo->valor_bruto = $valorFinalAtivo;
        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
