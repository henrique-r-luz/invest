<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;

class DesdoblaMais
{
    private ItensAtivo $itensAtivo;
    private Operacao $operacao;

    public function __construct($itensAtivo, $operacao)
    {
        $this->itensAtivo = $itensAtivo;
        $this->operacao = $operacao;
    }
}
