<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;


use app\models\financas\Operacao;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

class CalculaPorMediaPreco implements AtualizaAtivoInterface
{

    private Operacao $operacao;
    private string $tipoOperaco = '';

    public function __construct(Operacao $operacao)
    {
        $this->operacao = $operacao;
    }

    public function setTipoOperacao(string $tipoOperaco)
    {
        $this->tipoOperaco = $tipoOperaco;
        // não  implementado;
    }

    public function setOldOperacao(array $oldOperacao)
    {
        // não  implementado;
    }

    public function atualiza()
    {
        $itens_ativos_id = $this->operacao->itens_ativos_id;
        if ($this->tipoOperaco === TiposOperacoes::DELETE) {
            if (!$this->operacao->delete()) {
                throw new InvestException('Erro ao deletar operação');
            }
        }
        $recalculaAtivos = new RecalculaAtivos($itens_ativos_id);
        $recalculaAtivos->alteraIntesAtivo();
    }
}
