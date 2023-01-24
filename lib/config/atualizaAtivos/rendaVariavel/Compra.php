<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\ItenaAtivoAlteraCompra;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;

class Compra implements AtivosOperacoesInterface
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