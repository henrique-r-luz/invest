<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\cdbInter;

use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\ValorBrutoLiquidoInterface;
use app\lib\config\atualizaAtivos\rendaFixa\CalculaValorRendaFixa;

class CalculaValorBrutoLiquidoCDBItenter implements ValorBrutoLiquidoInterface
{
    public function __construct(
        private CalculaAritimeticaCDBInter  $calculaAritimetica,
        private ItensAtivo $itemAtivo
    ) {
    }

    public function calcula()
    {
        $operacao =  $this->calculaAritimetica->getOperacao();
        $oldOperacao = $this->calculaAritimetica->oldOperacao;
        $itemAtivo = $this->itemAtivo;

        return  CalculaValorRendaFixa::calcula($operacao, $oldOperacao, $itemAtivo, $this->calculaAritimetica);
    }
}
