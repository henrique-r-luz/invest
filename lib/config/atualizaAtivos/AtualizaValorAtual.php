<?php

namespace app\lib\config\atualizaAtivos;

use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;

class AtualizaValorAtual
{

    public static function atualizaValorBrutoLiquido($itensAtivo_id)
    {
        $recalculaAtivos = new RecalculaAtivos($itensAtivo_id);
        $recalculaAtivos->alteraIntesAtivo();
        $atualizaRendaVariavel = new AtualizaRendaVariavel($itensAtivo_id);
        $atualizaRendaVariavel->alteraIntesAtivo();
    }
}
