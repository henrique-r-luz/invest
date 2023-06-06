<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\normais;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\config\atualizaAtivos\FormOperacoes;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;
use app\lib\config\atualizaAtivos\ConfigAtualizacoesAtivos;
use app\lib\config\atualizaAtivos\rendaFixa\cdbInter\Compra;
use app\lib\config\atualizaAtivos\rendaVariavel\DesdobraMais;
use app\lib\config\atualizaAtivos\rendaVariavel\DesdobraMenos;
use app\lib\config\atualizaAtivos\rendaFixa\normais\VendaRendaFixa;

class CalculaAritimetica implements AtualizaAtivoInterface
{

    private Operacao $operacao;
    private array $oldOperacao;
    private $tipoOperaco;
    private ItensAtivo $itensAtivo;
    private $configAtualizacoesAtivos;

    public function __construct(Operacao $operacao)
    {

        $this->operacao = $operacao;
        $this->itensAtivo =  ItensAtivo::findOne($this->operacao->itens_ativos_id);
        $formOperacoes = new FormOperacoes();
        $formOperacoes->compra = new Compra($this->itensAtivo, $operacao);
        $formOperacoes->venda = new VendaRendaFixa($this->itensAtivo, $operacao);
        $formOperacoes->desdobraMais = new DesdobraMais($this->itensAtivo, $operacao);
        $formOperacoes->desdobraMenos = new DesdobraMenos($this->itensAtivo, $operacao);
        $this->configAtualizacoesAtivos = new ConfigAtualizacoesAtivos($formOperacoes);
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
        /**
         * @var AtivosOperacoesInterface $ativosOperacoesInterface
         */
        $ativosOperacoesInterface = $this->configAtualizacoesAtivos->getClasse($this->operacao->tipo);
        if ($this->tipoOperaco === TiposOperacoes::INSERIR) {
            $ativosOperacoesInterface->insere();
        }
        if ($this->tipoOperaco === TiposOperacoes::UPDATE) {
            $ativosOperacoesInterface->update($this->oldOperacao);
        }
        if ($this->tipoOperaco === TiposOperacoes::DELETE) {
            $ativosOperacoesInterface->delete();
        }
    }
}
