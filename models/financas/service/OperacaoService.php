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

namespace app\models\financas\service;

use app\lib\CajuiHelper;
use Yii;
use \Exception;
use app\models\financas\service\sincroniza\SincronizaFactory;

//use app\models\financas\Operacao;

class OperacaoService {

    //put your code here

    private $operacao;
    private $transaction;
    private $alteraAtivo;

    function __construct($operacao) {
        $this->operacao = $operacao;
    }

    public function load($post) {
        return $this->operacao->load($post);
    }

    /**
     * salva Operação.
     * Essa função realiza uma transação com a tabela ativo.
     * garantido a atualização da quantidade e valor de compra
     */
    public function acaoSalvaOperacao() {
        $connection = Yii::$app->db;
        $this->transaction = $connection->beginTransaction();
        $this->alteraAtivo = new AlteraAtivoOperacao();
        try {
            $this->salvaOperacao();
            $this->salvaAtivo();
            $this->corrigeAlteracaoAtivo();
            $this->sicronizaDadosAtivo();
            $this->transaction->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
            $this->transaction->rollBack();
            return false;
        }
    }

    public function acaoDeletaOperacao() {
        $connection = Yii::$app->db;
        $this->transaction = $connection->beginTransaction();
        $this->alteraAtivo = new AlteraAtivoOperacao();
        try {
            $this->deleteOperacao();
            $this->salvaAtivo();
            $this->sicronizaDadosAtivo();
            $this->transaction->commit();
            return true;
        } catch (Exception $ex) {
            throw new Exception('Ocorreu um erro ao deletar operação');
            $this->transaction->rollBack();
            return false;
        }
    }

    private function deleteOperacao() {
        if (!$this->operacao->delete()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            throw new Exception('O sistema não pode remover a operação:' . $erro . '. ' );
        }
    }

    private function salvaOperacao() {
        if (!$this->operacao->save()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            $this->operacao->addError('ativo_id', 'O sistema não pode alterar a operação:' . $erro . '. ');
            throw new Exception( 'O sistema não pode alterar a operação:' . $erro . '. ');
        }
    }

    private function salvaAtivo() {
        if (!$this->alteraAtivo->updateAtivo($this->operacao->ativo_id)) {
            throw new Exception('O sistema não pode atualizar o ativo. ');
        }
    }

    private function corrigeAlteracaoAtivo() {
        $ativo_id_antigo = $this->operacao->getOldAttribute('ativo_id');
        if ($ativo_id_antigo == null) {
            return true;
        }

        //essa ação acontece se ocorrer uma alteração do tipo de ativo
        if (!$this->alteraAtivo->updateAtivo($ativo_id_antigo)) {
            throw new Exception('O sistema não conseguiu atualizar o ativo:' . $ativo_id_antigo . '. ');
            // throw new Exception('O sistema não pode alterar o ativo:' . $this->ativo->codigo . '. ');
        }
    }


    private function sicronizaDadosAtivo() {
       
        SincronizaFactory::sincroniza('easy')->atualiza();
        SincronizaFactory::sincroniza('acao')->atualiza();
        SincronizaFactory::sincroniza('banco_inter')->atualiza();
       
    }

    public function getOpereacao() {
        return $this->operacao;
    }

}
