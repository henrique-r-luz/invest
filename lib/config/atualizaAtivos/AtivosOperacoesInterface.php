<?php

namespace app\lib\config\atualizaAtivos;

interface AtivosOperacoesInterface
{
    public function insere();
    public function delete();
    public function update($oldOperacao);
}
