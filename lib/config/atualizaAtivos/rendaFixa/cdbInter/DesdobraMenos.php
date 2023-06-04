<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\cdbInter;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\InsereDesdobramentoMais;
use app\lib\config\atualizaAtivos\InsereDesdobramentoMenos;

class DesdobraMenos implements AtivosOperacoesInterface
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
        InsereDesdobramentoMenos::insere($this->itensAtivo, $this->operacao);
    }


    public function delete()
    {
        InsereDesdobramentoMenos::delete($this->itensAtivo, $this->operacao);
    }

    public function update($oldOperacao)
    {
        InsereDesdobramentoMenos::update($oldOperacao, $this->itensAtivo, $this->operacao);
    }
}
