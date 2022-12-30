<?php

namespace app\lib\config\atualizaAtivos;

interface AtualizaAtivoInterface
{

    public function atualiza();
    public function setTipoOperacao(string $tipoOperaco);
}
