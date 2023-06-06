<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\cdbInter;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaItensAtivoPorData;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

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
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
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
        $aux = $this->operacao;
        DeleteOperacao::delete($aux);
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $this->itensAtivo->valor_compra += $this->operacao->valor;
        $this->itensAtivo->quantidade += $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido += $this->operacao->valor;
        $this->itensAtivo->valor_bruto += $this->operacao->valor;
        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    public function update($oldOperacao)
    {
        $recalculaAtivos = new RecalculaAtivos($this->itensAtivo->id);
        $recalculaAtivos->alteraIntesAtivo();

    }
}
