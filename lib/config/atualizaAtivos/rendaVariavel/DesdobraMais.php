<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;


use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\InsereDesdobramentoMais;

class DesdobraMais implements AtivosOperacoesInterface
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
        InsereDesdobramentoMais::insere($this->itensAtivo, $this->operacao);
    }

    public function delete()
    {
        InsereDesdobramentoMais::delete($this->itensAtivo, $this->operacao);
    }

    public function update($oldOperacao)
    {

        InsereDesdobramentoMais::update($this->itensAtivo, $this->operacao, $oldOperacao);
    }
}
