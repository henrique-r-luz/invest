<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\PrecoMedioVenda;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;

class Venda implements AtivosOperacoesInterface
{
    private ItensAtivo $itensAtivo;
    private Operacao $operacao;

    public function __construct($itensAtivo, $operacao)
    {
        $this->itensAtivo = $itensAtivo;
        $this->operacao = $operacao;
    }

    public function insere()
    {
        $precoMedio = $this->getPrecoMedio();
        $precoMedio = $this->salvaPrecoMedio($precoMedio);
        $this->itensAtivo->valor_compra -=  $precoMedio * $this->operacao->quantidade;
        $this->itensAtivo->quantidade -= $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido -= $this->operacao->valor;
        $this->itensAtivo->valor_bruto -= $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    private function getPrecoMedio()
    {
        $quantidade = 1;
        if ($this->itensAtivo->quantidade != 0) {
            $quantidade =  $this->itensAtivo->quantidade;
        }
        return ($this->itensAtivo->valor_liquido / $quantidade);
    }

    private function salvaPrecoMedio($precoMedioValor)
    {

        $precoMedio = new PrecoMedioVenda();
        $valorVenda = $precoMedioValor;
        $precoMedio->valor = $valorVenda;
        $precoMedio->operacoes_id = $this->operacao->id;
        if (!$precoMedio->save()) {
            $erro  = CajuiHelper::processaErros($precoMedio->getErrors());
            throw new InvestException($erro);
        }
        return $valorVenda;
    }

    public function delete()
    {
        $precoMedio = $this->removePrecoMedioVenda();
        $this->itensAtivo->valor_compra += $precoMedio * $this->operacao->quantidade;
        $this->itensAtivo->quantidade += $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido += $this->operacao->valor;
        $this->itensAtivo->valor_bruto += $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
        DeleteOperacao::delete($this->operacao);
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

    public function update($oldOperacao)
    {
        if (empty($oldOperacao) || $oldOperacao == null) {
            throw new InvestException('O oldOperacao não foi definido pelo sistema. ');
        }
        $precoMedioVenda = PrecoMedioVenda::find()->where(['operacoes_id' => $this->operacao->id])->one();
        $precoMedio  = $precoMedioVenda->valor;
        $this->itensAtivo->valor_compra -=  ($precoMedio * $this->operacao->quantidade) - ($oldOperacao['quantidade'] * $precoMedio);
        $this->itensAtivo->quantidade -= $this->operacao->quantidade - $oldOperacao['quantidade'];
        $this->itensAtivo->valor_liquido -= $this->operacao->valor - $oldOperacao['valor'];
        $this->itensAtivo->valor_bruto -= $this->operacao->valor - $oldOperacao['valor'];

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
