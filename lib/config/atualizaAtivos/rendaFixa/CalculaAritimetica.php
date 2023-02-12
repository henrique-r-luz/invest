<?php

namespace app\lib\config\atualizaAtivos\rendaFixa;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;

class CalculaAritimetica implements AtualizaAtivoInterface
{
    private Operacao $operacao;
    private array $oldOperacao;
    private $tipoOperaco;
    private Compra $compra;
    private Venda $venda;
    private ItensAtivo $itensAtivo;
    private DesdobraMais $desdobraMais;
    private DesdobraMenos $desdobraMenos;

    public function __construct(Operacao $operacao)
    {

        $this->operacao = $operacao;
        $this->itensAtivo =  ItensAtivo::findOne($this->operacao->itens_ativos_id);
        $this->compra = new Compra($this->itensAtivo, $operacao);
        $this->venda = new Venda($this->itensAtivo, $operacao);
        $this->desdobraMais = new DesdobraMais($this->itensAtivo, $operacao);
        $this->desdobraMenos = new DesdobraMenos($this->itensAtivo, $operacao);
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
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->compra->insere();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->venda->insere();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->desdobraMais->insere();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->desdobraMenos->insere();
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
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS] && $this->tipoOperaco === TiposOperacoes::DELETE) {
            $this->desdobraMais->delete();
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS] && $this->tipoOperaco === TiposOperacoes::DELETE) {
            $this->desdobraMenos->delete();
            return;
        }

        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA] && $this->tipoOperaco === TiposOperacoes::UPDATE) {
            $this->compra->update($this->oldOperacao);
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $this->tipoOperaco === TiposOperacoes::UPDATE) {
            $this->venda->update($this->oldOperacao);
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS] && $this->tipoOperaco === TiposOperacoes::UPDATE) {
            $this->desdobraMais->update($this->oldOperacao);
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS] && $this->tipoOperaco === TiposOperacoes::UPDATE) {
            $this->desdobraMenos->update($this->oldOperacao);
            return;
        }


        throw new InvestException('Codiação não implementadas para a classe: app\lib\config\atualizaAtivos\rendaFixa\RendaFixa');
    }
}
