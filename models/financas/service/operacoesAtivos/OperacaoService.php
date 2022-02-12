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
use \Exception;
use app\lib\CajuiHelper;
use app\models\financas\service\sincroniza\Sincroniza;
use app\models\financas\service\sincroniza\SincronizaFactory;
use app\models\financas\service\operacoesAtivos\AlteraAtivoOperacao;


/**
 * classe que gerencia os seviços de oprações
 *
 * @author henrique.luz <henrique_r_luz@yahoo.com.br>
 */
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
            $msg = 'O sistema não pode alterar a operação:' . $erro . '. ';
            $this->operacao->addError('itens_ativos_id', $msg);
            throw new Exception($msg);
        }
    }

    private function salvaAtivo() {
        if (!$this->alteraAtivo->updateAtivo($this->operacao->itens_ativos_id)) {
            throw new Exception('O sistema não pode atualizar o ativo. ');
        }
    }

    private function corrigeAlteracaoAtivo() {
        $ativo_id_antigo = $this->operacao->getOldAttribute('itens_ativos_id');
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
        Sincroniza::atualizaAtivos();
    }

    public function getOpereacao() {
        return $this->operacao;
    }

}
