<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service;


use \app\models\financas\Ativo;
use \app\models\financas\Operacao;
use yii\db\Query;

/**
 * Aletara os ativo através do CRUD de operação
 *
 * @author henrique
 */
class AlteraAtivoOperacao {
    
    private $ativo_id;
    private $erro;
    
     /**
     * atualiza o registro de ativos ao salvar operação.
     * campos alterados quantidade e valor de compra
     * @return boolean
     */
    
    public function updateAtivo($ativo_id) {
        $this->ativo_id = $ativo_id;
        $ativo = Ativo::findOne($ativo_id);
        
        $valoresAtivo = Operacao::queryDadosAtivos($ativo_id);
      
        
        $ativo->quantidade = max(0, $valoresAtivo[0]['quantidade']);
        
        if ($ativo->quantidade <= 0) {
            $ativo->valor_compra = 0;
            $ativo->valor_bruto = 0;
            $ativo->valor_liquido = 0;
        } else {
            $ativo->valor_compra = round(max(0,$valoresAtivo[0]['valor_compra']),2);  
        }
        if ($ativo->save()) {
            return true;
        } else {
            $this->erro = CajuiHelper::processaErros($ativo->getErrors());
            return false;
        }
    }
    
    
    public function getErro(){
        return $erro;
    }
    
    
    
}
