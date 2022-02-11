<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\operacoesAtivos;


use yii\db\Query;
use app\lib\CajuiHelper;
use \app\models\financas\Ativo;
use \app\models\financas\Operacao;
use app\models\financas\ItensAtivo;

/**
 * Aletara os ativo através do CRUD de operação
 *
 * @author henrique
 */
class AlteraAtivoOperacao {
    
    private $itens_ativos_id;
    private $erro;
    
     /**
     * atualiza o registro de ativos ao salvar operação.
     * campos alterados quantidade e valor de compra
     * @return boolean
     */
    
    public function updateAtivo($itens_ativos_id) {
        $this->itens_ativos_id = $itens_ativos_id;
        $itensAtivo = ItensAtivo::findOne($itens_ativos_id);
        
        $dadosOperacoesAtivos = new DadosOperacoesAtivos();
        $dadosOperacoesAtivos->setItens_ativos_id($itens_ativos_id);
        $dados = $dadosOperacoesAtivos->geraQuery();
        $itensAtivo->quantidade = max(0, $dados[0]['quantidade']);
        if ($itensAtivo->save()) {
            return true;
        } else {
            $this->erro = CajuiHelper::processaErros($itensAtivo->getErrors());
            return false;
        }
    }
    
    
    public function getErro(){
        return $this->erro;
    }
    
    
    
}
