<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\PrecoMedioVenda;

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
        $precoMedio = $this->getPrecoMedio($itensAtivo);
        $precoMedio = $this->salvaPrecoMedio($precoMedio);
        $itensAtivo->valor_compra -=  $precoMedio;
        $itensAtivo->quantidade -= $this->operacao->quantidade;
        $itensAtivo->valor_liquido -= $this->operacao->valor;
        $itensAtivo->valor_bruto -= $this->operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    private function getPrecoMedio($itensAtivo)
    {
        $quantidade = 1;
        if ($itensAtivo->quantidade != 0) {
            $quantidade =  $itensAtivo->quantidade;
        }
        return ($itensAtivo->valor_liquido / $quantidade);
    }

    private function salvaPrecoMedio($precoMedioValor)
    {

        $precoMedio = new PrecoMedioVenda();
        $valorVenda = $precoMedioValor * $this->operacao->quantidade;
        $precoMedio->valor = $valorVenda;
        $precoMedio->operacoes_id = $this->operacao->id;
        if (!$precoMedio->save()) {
            $erro  = CajuiHelper::processaErros($precoMedio->getErrors());
            throw new InvestException($erro);
        }
        return $valorVenda;
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
        $this->deleteOperacao();
    }
    private function deleteVenda($itensAtivo)
    {
        $precoMedio = $this->removePrecoMedioVenda();
        $itensAtivo->valor_compra += $precoMedio;
        $itensAtivo->quantidade += $this->operacao->quantidade;
        $itensAtivo->valor_liquido += $this->operacao->valor;
        $itensAtivo->valor_bruto += $this->operacao->valor;

        if (!$itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($itensAtivo->getErrors());
            throw new InvestException($erro);
        }
        $this->deleteOperacao();
    }

    private function removePrecoMedioVenda()
    {
        $valorPrecoMedio = 0;
        $precoMedioVenda = PrecoMedioVenda::find()->where(['operacoes_id' => $this->operacao->id])->one();
        if (empty($precoMedioVenda)) {
            return null;
        }
        $valorPrecoMedio = $precoMedioVenda->valor;
        if (!$precoMedioVenda->delete()) {
            throw new InvestException('O preço médio não pode ser removido.');
        }
        return $valorPrecoMedio;
    }

    private function deleteOperacao()
    {
        if (!$this->operacao->delete()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            throw new InvestException('O sistema não pode remover a operação:' . $erro . '. ');
        }
    }
}
