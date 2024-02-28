<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\normais;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\ValorBrutoLiquidoInterface;

class CalculaValorBrutoLiquidoFixa implements ValorBrutoLiquidoInterface
{
    public function __construct(
        private CalculaAritimetica $calculaAritimetica,
        private ItensAtivo $itemAtivo
    ) {
    }

    public function calcula()
    {
        $operacao =  $this->calculaAritimetica->getOperacao();
        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
            $this->itemAtivo->valor_bruto -= $operacao->valor;
            $this->itemAtivo->valor_liquido -= $operacao->valor;
        }
        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA]) {
            $this->itemAtivo->valor_bruto += $operacao->valor;
            $this->itemAtivo->valor_liquido += $operacao->valor;
        }
        return $this->itemAtivo;
    }
}
