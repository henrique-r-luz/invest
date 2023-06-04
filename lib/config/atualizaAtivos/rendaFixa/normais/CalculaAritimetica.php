<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\normais;

use app\models\financas\Operacao;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;

class CalculaAritimetica implements AtualizaAtivoInterface
{

    private $tipoOperaco;
    private array $oldOperacao;
    private Operacao $operacao;

    public function __construct(Operacao $operacao)
    {
        $this->operacao = $operacao;
    }

    public function setTipoOperacao(string $tipoOperaco)
    {
        $this->tipoOperaco = $tipoOperaco;
    }

    public function setOldOperacao(array $oldOperacao)
    {
        $this->oldOperacao = $oldOperacao;
    }

    public function atualiza()
    {
    }
}
