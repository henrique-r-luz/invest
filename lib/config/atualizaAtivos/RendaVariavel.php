<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\CajuiHelper;
use app\lib\helpers\InvestException;
use app\models\financas\ItensAtivo;
use app\models\financas\Operacao;

class RendaVariavel implements AtualizaAtivoInterface
{

    private Operacao $operacao;
    private string $tipoOperaco;

    public function __construct(Operacao $operacao)
    {
        $this->operacao = $operacao;
    }

    public function setTipoOperacao(string $tipoOperaco)
    {
        $this->tipoOperaco = $tipoOperaco;
    }

    public function atualiza()
    {
        $itensAtivo =  ItensAtivo::findOne($this->operacao->itens_ativos_id);
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->compra($itensAtivo);
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $this->tipoOperaco === TiposOperacoes::INSERIR) {
            $this->venda($itensAtivo);
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA] && $this->tipoOperaco === TiposOperacoes::DELETE) {
            $this->deleteCompra($itensAtivo);
            return;
        }
        if ($this->operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $this->tipoOperaco === TiposOperacoes::DELETE) {
            $this->deleteVenda($itensAtivo);
            return;
        }

        throw new InvestException('Codiação não implementadas para a classe: app\lib\config\atualizaAtivos\RendaVariavel');
    }

    private function compra($itensAtivo)
    {
        $itensAtivo->valor_compra += $this->operacao->valor;
        $itensAtivo->quantidade += $this->operacao->quantidade;
        $itensAtivo->valor_liquido += $this->operacao->valor;
        $itensAtivo->valor_bruto += $this->operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }


    private function venda($itensAtivo)
    {
        /**
         * preco medio de venda deve ser persistido 
         */
        $quantidade = 1;
        if ($itensAtivo->quantidade != 0) {
            $quantidade =  $itensAtivo->quantidade;
        }
        $precoMedio = $itensAtivo->valor_liquido / $quantidade;
        $itensAtivo->valor_compra -= $precoMedio;
        $itensAtivo->quantidade -= $this->operacao->quantidade;
        $itensAtivo->valor_liquido -= $this->operacao->valor;
        $itensAtivo->valor_bruto -= $this->operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    private function deleteCompra($itensAtivo)
    {
        $itensAtivo->valor_compra -= $this->operacao->valor;
        $itensAtivo->quantidade -= $this->operacao->quantidade;
        $itensAtivo->valor_liquido -= $this->operacao->valor;
        $itensAtivo->valor_bruto -= $this->operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
    private function deleteVenda($itensAtivo)
    {
        $quantidade = 1;
        if ($itensAtivo->quantidade != 0) {
            $quantidade =  $itensAtivo->quantidade;
        }
        $precoMedio = $itensAtivo->valor_liquido / $quantidade;
        $itensAtivo->valor_compra += $this->operacao->valor;
        $itensAtivo->quantidade += $this->operacao->quantidade;
        $itensAtivo->valor_liquido += $this->operacao->valor;
        $itensAtivo->valor_bruto += $this->operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
