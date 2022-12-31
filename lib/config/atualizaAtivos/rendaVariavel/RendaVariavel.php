<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;


use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;

class RendaVariavel implements AtualizaAtivoInterface
{

    private Operacao $operacao;
    private string $tipoOperaco;
    private ItensAtivo $itensAtivo;
    private Compra $compra;
    private Venda $venda;

    public function __construct(Operacao $operacao)
    {

        $this->operacao = $operacao;
        $this->itensAtivo =  ItensAtivo::findOne($this->operacao->itens_ativos_id);
        $this->compra = new Compra($this->itensAtivo, $operacao);
        $this->venda  = new Venda($this->itensAtivo, $operacao);
    }

    public function setTipoOperacao(string $tipoOperaco)
    {
        $this->tipoOperaco = $tipoOperaco;
    }

    public function atualiza()
    {

        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->compra->insere();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->venda->insere();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA] && $this->tipoOperaco === TiposOperacoes::DELETE) {
            $this->compra->delete();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $this->tipoOperaco === TiposOperacoes::DELETE) {
            $this->venda->delete();
            return;
        }


        throw new InvestException('Codiação não implementadas para a classe: app\lib\config\atualizaAtivos\rendaVariavel\RendaVariavel');
    }
}
