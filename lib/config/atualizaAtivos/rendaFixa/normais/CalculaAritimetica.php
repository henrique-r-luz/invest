<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\normais;

use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\FormOperacoes;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;
use app\lib\config\atualizaAtivos\ConfigAtualizacoesAtivos;
use app\lib\config\atualizaAtivos\rendaFixa\cdbInter\Compra;
use app\lib\config\atualizaAtivos\rendaVariavel\DesdobraMais;
use app\lib\config\atualizaAtivos\rendaVariavel\DesdobraMenos;
use app\lib\config\atualizaAtivos\rendaFixa\normais\VendaRendaFixa;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

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
        $itens_ativos_id = $this->operacao->itens_ativos_id;
        if ($this->tipoOperaco === TiposOperacoes::DELETE) {
            if (!$this->operacao->delete()) {
                throw new InvestException('Erro ao deletar operação');
            }
        }
        $recalculaAtivos = new RecalculaAtivos($itens_ativos_id);
        $recalculaAtivos->alteraIntesAtivo();
        /* $ativosOperacoesInterface = $this->configAtualizacoesAtivos->getClasse($this->operacao->tipo);
        if ($this->tipoOperaco === TiposOperacoes::INSERIR) {
            $ativosOperacoesInterface->insere();
        }
        if ($this->tipoOperaco === TiposOperacoes::UPDATE) {
            $ativosOperacoesInterface->update($this->oldOperacao);
        }
        if ($this->tipoOperaco === TiposOperacoes::DELETE) {
            $ativosOperacoesInterface->delete();
        }*/
    }
}
