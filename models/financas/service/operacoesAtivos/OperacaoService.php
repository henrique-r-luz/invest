<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OperacaoService
 *
 * @author henrique
 */

namespace app\models\financas\service\operacoesAtivos;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\lib\helpers\InvestException;
use app\models\financas\service\sincroniza\Sincroniza;
use app\lib\config\atualizaAtivos\AtualizaAtivoOperacaoFactory;
use app\lib\config\atualizaAtivos\rendaFixa\cdbInter\CalculaAritimeticaCDBInter;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;


/**
 * classe que gerencia os seviços de oprações
 *
 * @author henrique.luz <henrique_r_luz@yahoo.com.br>
 */
class OperacaoService
{

    //put your code here

    private Operacao $operacao;
    private array $oldOperacao = [];
    private string $tipoOperacao;

    function __construct($operacao, $tipoOperacao)
    {
        $this->operacao = $operacao;
        $this->tipoOperacao = $tipoOperacao;
    }

    public function load($post)
    {
        return $this->operacao->load($post);
    }

    /**
     * salva Operação.
     * Essa função realiza uma transação com a tabela ativo.
     * garantido a atualização da quantidade e valor de compra
     */
    public function acaoSalvaOperacao()
    {

        $this->salvaOperacao();
        $this->salvaAtivo();
    }

    public function acaoDeletaOperacao()
    {
        $this->salvaAtivo();
    }



    private function salvaOperacao()
    {
        $this->oldOperacao = $this->operacao->getOldAttributes();
        if (!$this->operacao->save()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            $msg = 'O sistema não pode alterar a operação:' . $erro . '. ';
            throw new InvestException($msg);
        }
    }

    /**
     * O cálculo do preço médio ocorre no momento de salvar o ativo 
     */
    private function salvaAtivo()
    {
        /** @var AtualizaAtivoInterface */
        $atualizaOperacao =  AtualizaAtivoOperacaoFactory::getObjeto($this->operacao);

        $atualizaOperacao->setOldOperacao($this->oldOperacao);
        $atualizaOperacao->setTipoOperacao($this->tipoOperacao);
        $atualizaOperacao->atualiza();
    }

    public function getOpereacao()
    {
        return $this->operacao;
    }
}
