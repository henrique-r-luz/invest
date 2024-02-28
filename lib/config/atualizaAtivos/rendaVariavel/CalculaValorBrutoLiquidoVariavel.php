<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\lib\config\atualizaAtivos\ValorBrutoLiquidoInterface;
use app\models\financas\ItensAtivo;

class CalculaValorBrutoLiquidoVariavel implements ValorBrutoLiquidoInterface
{

    public function __construct(
        private ItensAtivo $itemAtivo
    ) {
    }
    public function calcula()
    {
        $valor = $this->itemAtivo->quantidade * $this->itemAtivo->preco_valor;
        $this->itemAtivo->valor_bruto = $valor;
        $this->itemAtivo->valor_liquido = $valor;
        return $this->itemAtivo;
    }
}
