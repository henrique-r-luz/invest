<?php

namespace app\lib\config\atualizaAtivos\rendaFixa;

use app\models\financas\Operacao;
use app\lib\config\atualizaAtivos\TiposOperacoes;

class CalculaValorRendaFixa
{
    public static function calcula($operacao, $oldOperacao, $itemAtivo, $calculaAritimetica)
    {
        if ($calculaAritimetica->tipoOperacao === TiposOperacoes::DELETE) {
            if ($operacao['tipo'] == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
                $itemAtivo->valor_bruto += $operacao['valor'];
                $itemAtivo->valor_liquido += $operacao['valor'];
            }
            if ($operacao['tipo'] == Operacao::tipoOperacaoId()[Operacao::COMPRA]) {
                $itemAtivo->valor_bruto -= $operacao['valor'];
                $itemAtivo->valor_liquido -= $operacao['valor'];
            }

            return $itemAtivo;
        }

        if (empty($oldOperacao)) {
            if ($oldOperacao['tipo'] == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
                $itemAtivo->valor_bruto += $oldOperacao['valor'];
                $itemAtivo->valor_liquido += $oldOperacao['valor'];
            }
            if ($oldOperacao['tipo'] == Operacao::tipoOperacaoId()[Operacao::COMPRA]) {
                $itemAtivo->valor_bruto -= $oldOperacao['valor'];
                $itemAtivo->valor_liquido -= $oldOperacao['valor'];
            }
        }

        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
            $itemAtivo->valor_bruto -= $operacao->valor;
            $itemAtivo->valor_liquido -= $operacao->valor;
        }
        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA]) {
            $itemAtivo->valor_bruto += $operacao->valor;
            $itemAtivo->valor_liquido += $operacao->valor;
        }
        return $itemAtivo;
    }
}
