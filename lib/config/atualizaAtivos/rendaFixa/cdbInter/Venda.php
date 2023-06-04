<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\cdbInter;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;

class Venda implements AtivosOperacoesInterface
{

    private ItensAtivo $itensAtivo;
    private Operacao $operacao;

    public function __construct(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $this->operacao = $operacao;
        $this->itensAtivo = $itensAtivo;
    }

    public function insere()
    {

        $this->itensAtivo->valor_compra -= $this->operacao->valor;
        $this->itensAtivo->quantidade -= $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido -= $this->operacao->valor;
        $this->itensAtivo->valor_bruto -= $this->operacao->valor;
        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }


    public function delete()
    {
        $this->itensAtivo->valor_compra += $this->operacao->valor;
        $this->itensAtivo->quantidade += $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido += $this->operacao->valor;
        $this->itensAtivo->valor_bruto += $this->operacao->valor;
        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
        DeleteOperacao::delete($this->operacao);
    }

    public function update($oldOperacao)
    {
        $this->itensAtivo->valor_compra = ($this->itensAtivo->valor_compra + $oldOperacao['valor']) - $this->operacao->valor; //abs($this->operacao->valor  - $oldOperacao['valor']);
        $this->itensAtivo->quantidade = ($this->itensAtivo->quantidade + $oldOperacao['quantidade']) - $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido = ($this->itensAtivo->valor_liquido + $oldOperacao['valor']) - $this->operacao->valor;
        $this->itensAtivo->valor_bruto = ($this->itensAtivo->valor_bruto + $oldOperacao['valor']) - $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
