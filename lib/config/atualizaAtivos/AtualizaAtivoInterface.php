<?php

namespace app\lib\config\atualizaAtivos;

use app\models\financas\Operacao;

interface AtualizaAtivoInterface
{

    public function atualiza();
    public function getOperacao();
    public function setOldOperacao($oldOperacao);
    public function setTipoOperacao(string $tipoOperaco);
}
