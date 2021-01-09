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

use app\models\financas\Sincroniza;
use Yii;
use yii\db\Exception;
use app\lib\CajuiHelper;
use \app\lib\Categoria;
use \app\models\financas\Ativo;
use \app\models\financas\Operacao;

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
            $this->transaction->rollBack();
            return false;
        }
    }

    private function deleteOperacao() {
        if (!$this->operacao->delete()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            $this->operacao->addError('ativo_id', 'O sistema não pode remover a operação:' . $erro . '. ');
            //throw new Exception('O sistema não pode alterar o ativo:' . $this->ativo->codigo . '. ');
            throw new Exception('');
        }
    }

    private function salvaOperacao() {
        if (!$this->operacao->save()) {
            $erro = CajuiHelper::processaErros($this->operacao->getErrors());
            $this->operacao->addError('ativo_id', 'O sistema não pode alterar a operação:' . $erro . '. ');
            //throw new Exception('O sistema não pode alterar o ativo:' . $this->ativo->codigo . '. ');
            throw new Exception('');
        }
    }

    private function salvaAtivo() {

        if (!$this->alteraAtivo->updateAtivo($this->operacao->ativo_id)) {
            $this->operacao->addError('ativo_id', 'O sistema não pode atualizar o ativo. ');
            throw new Exception('');
        }
    }

    private function corrigeAlteracaoAtivo() {
        $ativo_id_antigo = $this->operacao->getOldAttribute('ativo_id');
        if ($ativo_id_antigo == null) {
            return true;
        }

        //essa ação acontece se ocorrer uma alteração do tipo de ativo
        if (!$this->alteraAtivo->updateAtivo($ativo_id_antigo)) {
            $this->operacao->addError('ativo_id', 'O sistema não conseguiu atualizar o ativo:' . $ativo_id_antigo . '. ');
            throw new Exception('');
            // throw new Exception('O sistema não pode alterar o ativo:' . $this->ativo->codigo . '. ');
        }
    }


    private function sicronizaDadosAtivo() {
        $sincroniza = new Sincroniza();
        $msgEasy = '';
        $msgCotacao = '';
        list($respEasy, $msgEasy) = $sincroniza->easy();
        list($respCotacao, $msgCotacao) = $sincroniza->cotacaoAcao();
        if (!($respEasy && $respCotacao)) {
            $this->operacao->addError('ativo_id', 'erro:</br>' . $msgEasy . '</br>' . $msgCotacao);
            throw new Exception('');
        }
    }

    public function getOpereacao() {
        return $this->operacao;
    }

}
