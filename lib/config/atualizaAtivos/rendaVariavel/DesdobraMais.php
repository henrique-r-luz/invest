<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;


use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\AtualizaValorAtual;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaItensAtivoPorData;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;

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
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $this->itensAtivo->quantidade += $this->operacao->quantidade;
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
        $this->itensAtivo->quantidade -= $this->operacao->quantidade;
        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    public function update($oldOperacao)
    {

        AtualizaValorAtual::atualizaValorBrutoLiquido($this->itensAtivo->id);
    }
}
