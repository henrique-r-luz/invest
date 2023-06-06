<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use yii\db\Query;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;

use app\lib\config\atualizaAtivos\AtualizaValorAtual;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;


class Venda implements AtivosOperacoesInterface
{
    private ItensAtivo $itensAtivo;
    private Operacao $operacao;
    private $precoMedio = 0;

    public function __construct($itensAtivo, $operacao)
    {
        $this->itensAtivo = $itensAtivo;
        $this->operacao = $operacao;
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
        $getPrecoCadastrado = new GetPrecoCadastrado($this->itensAtivo);
        $valorFinalAtivo = $getPrecoCadastrado->getValor();
        $this->itensAtivo->valor_liquido = $valorFinalAtivo;
        $this->itensAtivo->valor_bruto = $valorFinalAtivo;

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
        $getPrecoCadastrado = new GetPrecoCadastrado($this->itensAtivo);
        $valorFinalAtivo = $getPrecoCadastrado->getValor();
        $this->itensAtivo->valor_liquido = $valorFinalAtivo;
        $this->itensAtivo->valor_bruto = $valorFinalAtivo;

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
