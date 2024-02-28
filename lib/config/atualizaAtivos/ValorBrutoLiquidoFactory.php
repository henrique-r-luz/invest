<?php

namespace app\lib\config\atualizaAtivos;


use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaPorMediaPreco;
use app\lib\config\atualizaAtivos\rendaFixa\normais\CalculaAritimetica;
use app\lib\config\atualizaAtivos\rendaFixa\normais\CalculaValorBrutoLiquidoFixa;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaValorBrutoLiquidoVariavel;
use app\models\financas\ItensAtivo;
use app\models\financas\Operacao;

class ValorBrutoLiquidoFactory
{

    public static function getObjeto(AtualizaAtivoInterface $class, ItensAtivo $itemAtivo)
    {

        if ($class instanceof CalculaPorMediaPreco) {
            return new CalculaValorBrutoLiquidoVariavel($itemAtivo);
        }
        if ($class instanceof CalculaAritimetica) {
            return new CalculaValorBrutoLiquidoFixa($class, $itemAtivo);
        }
    }
}
