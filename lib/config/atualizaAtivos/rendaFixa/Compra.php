<?php

namespace app\lib\config\atualizaAtivos\rendaFixa;


use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\ItenaAtivoAlteraCompra;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;

class Compra implements AtivosOperacoesInterface
{

    private Operacao $operacao;
    private ItensAtivo $itensAtivo;

    public function __construct(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $this->operacao = $operacao;
        $this->itensAtivo = $itensAtivo;
    }

    public function insere()
    {
        ItenaAtivoAlteraCompra::compra($this->itensAtivo, $this->operacao);
    }


    public function delete()
    {
        ItenaAtivoAlteraCompra::delete($this->itensAtivo, $this->operacao);
    }

    public function update($oldOperacao)
    {
        ItenaAtivoAlteraCompra::update($oldOperacao, $this->itensAtivo, $this->operacao);
    }
}
