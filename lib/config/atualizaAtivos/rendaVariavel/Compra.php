<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use app\lib\config\atualizaAtivos\rendaVariavel\DeleteOperacao;
use app\lib\config\atualizaAtivos\rendaVariavel\GetPrecoCadastrado;
use app\lib\config\atualizaAtivos\rendaVariavel\CalculaItensAtivoPorData;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;

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
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $this->itensAtivo->valor_compra += $this->operacao->valor;
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


    public function delete()
    {
        $aux = $this->operacao;
        DeleteOperacao::delete($aux);
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $this->itensAtivo->valor_compra -= $this->operacao->valor;
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

    public function update($oldOperacao)
    {
        $recalculaAtivos = new RecalculaAtivos($this->itensAtivo->id);
        $recalculaAtivos->alteraIntesAtivo();
        $atualizaRendaVariavel = new AtualizaRendaVariavel($this->itensAtivo->id);
        $atualizaRendaVariavel->alteraIntesAtivo();
    }
}
