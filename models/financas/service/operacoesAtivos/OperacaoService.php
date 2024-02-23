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
    private string $tipoOperaco;
    private array $oldOperacao = [];

    function __construct($operacao, $tipoOperacao)
    {
        $this->operacao = $operacao;
        $this->tipoOperaco = $tipoOperacao;
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
        $recalculaAtivos = new RecalculaAtivos();
        if (!$this->operacao->save()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            $msg = 'O sistema não pode alterar a operação:' . $erro . '. ';
            throw new InvestException($msg);
        }
    }


    private function salvaAtivo()
    {
        /** @var AtualizaAtivoInterface */
        $atualizaOperacao =  AtualizaAtivoOperacaoFactory::getObjeto($this->operacao);
        $atualizaOperacao->setTipoOperacao($this->tipoOperaco);
        $atualizaOperacao->setOldOperacao($this->oldOperacao);
        $atualizaOperacao->atualiza();
    }

    public function getOpereacao()
    {
        return $this->operacao;
    }
}
