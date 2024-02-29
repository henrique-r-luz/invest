<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\normais;

use app\models\financas\Operacao;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\RecalculaAtivosLib;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;

class CalculaAritimetica implements AtualizaAtivoInterface
{

    private Operacao $operacao;

    public string $tipoOperacao;

    public string $oldOperacao;

    public function __construct(Operacao $operacao)
    {

        $this->operacao = $operacao;
    }


    public function getOperacao()
    {
        return $this->operacao;
    }

    public function setOldOperacao($oldOperacao)
    {
        $this->oldOperacao = $oldOperacao;
    }

    public function setTipoOperacao(string $tipoOperacao)
    {
        $this->tipoOperacao = $tipoOperacao;
        // não  implementado;
    }



    public function atualiza()
    {
        $itens_ativos_id = $this->operacao->itens_ativos_id;
        if ($this->operacao->tipo === TiposOperacoes::DELETE) {
            if (!$this->operacao->delete()) {
                throw new InvestException('Erro ao deletar operação');
            }
        }
        $recalculaAtivos = new RecalculaAtivosLib($itens_ativos_id, $this);
        $recalculaAtivos->alteraIntesAtivo();
    }
}
