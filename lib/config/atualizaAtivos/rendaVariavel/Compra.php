<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\Operacao;

class Compra
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
        $this->itensAtivo->valor_compra += $this->operacao->valor;
        $this->itensAtivo->quantidade += $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido += $this->operacao->valor;
        $this->itensAtivo->valor_bruto += $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }


    public function delete()
    {
        $this->itensAtivo->valor_compra -= $this->operacao->valor;
        $this->itensAtivo->quantidade -= $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido -= $this->operacao->valor;
        $this->itensAtivo->valor_bruto -= $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
        DeleteOperacao::delete($this->operacao);
    }
}
