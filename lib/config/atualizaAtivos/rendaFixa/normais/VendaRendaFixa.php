<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\normais;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\AtualizaValorAtual;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\rendaVariavel\PrecoMedio;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaItensAtivoPorData;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

class VendaRendaFixa implements AtivosOperacoesInterface
{
    private Operacao $operacao;
    private ItensAtivo $itensAtivo;
    private $precoMedio;

    public function __construct(ItensAtivo $itensAtivo, Operacao $operacao)
    {
        $this->operacao = $operacao;
        $this->itensAtivo = $itensAtivo;
        $precoMedio = new PrecoMedio($itensAtivo, $operacao);
        $this->precoMedio =  $precoMedio->getPrecoMedio();
    }
    public function insere()
    {
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $this->itensAtivo->valor_compra -=  $this->precoMedio * $this->operacao->quantidade;
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

        $precoMedio = $this->precoMedio;
        $operacaoAux = $this->operacao;
        DeleteOperacao::delete($operacaoAux);
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        if ($precoMedio !== 0) {
            $this->itensAtivo->valor_compra += $precoMedio * $this->operacao->quantidade;
        } else {
            $this->itensAtivo->valor_compra += $this->operacao->valor;
        }
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
        AtualizaValorAtual::atualizaValorBrutoLiquido($this->itensAtivo->id);
    }
}
