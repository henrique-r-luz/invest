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
use app\lib\helpers\InvestException;
use app\models\financas\service\sincroniza\Sincroniza;
use app\lib\config\atualizaAtivos\AtualizaAtivoOperacaoFactory;
use app\models\financas\service\operacoesAtivos\AlteraAtivoOperacao;


/**
 * classe que gerencia os seviços de oprações
 *
 * @author henrique.luz <henrique_r_luz@yahoo.com.br>
 */
class OperacaoService
{

    //put your code here

    private $operacao;
    private $transaction;
    private string $tipoOperaco;

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
        $connection = Yii::$app->db;
        $this->transaction = $connection->beginTransaction();
        try {

            $this->salvaOperacao();
            $this->salvaAtivo();
            $this->transaction->commit();
            return true;
        } catch (InvestException $ex) {
            $this->transaction->rollBack();
            throw new InvestException($ex->getMessage());
            return false;
        }
    }

    public function acaoDeletaOperacao()
    {
        $connection = Yii::$app->db;
        $this->transaction = $connection->beginTransaction();
        try {
            $this->deleteOperacao();
            $this->salvaAtivo();
            $this->transaction->commit();
            return true;
        } catch (InvestException $ex) {
            throw new InvestException('Ocorreu um erro ao deletar operação');
            $this->transaction->rollBack();
            return false;
        }
    }

    private function deleteOperacao()
    {
        if (!$this->operacao->delete()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            throw new InvestException('O sistema não pode remover a operação:' . $erro . '. ');
        }
    }

    private function salvaOperacao()
    {
        $this->ativo_id_antigo = $this->operacao->getOldAttribute('itens_ativos_id');
        if (!$this->operacao->save()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            $msg = 'O sistema não pode alterar a operação:' . $erro . '. ';
            $this->operacao->addError('itens_ativos_id', $msg);
            throw new InvestException($msg);
        }
    }

    private function salvaAtivo()
    {
        /** @var AtualizaAtivoInterface */
        $atualizaOperacao =  AtualizaAtivoOperacaoFactory::getObjeto($this->operacao);
        $atualizaOperacao->setTipoOperacao($this->tipoOperaco);
        $atualizaOperacao->atualiza();
    }

    public function getOpereacao()
    {
        return $this->operacao;
    }
}
