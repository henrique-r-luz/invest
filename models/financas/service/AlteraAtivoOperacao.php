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
        
        $valoresAtivo = $this->valorDeCompraEquantidade();
        
        $ativo->quantidade = max(0,$valoresAtivo[0]['quantidade']);
        
        if ($ativo->quantidade <= 0) {
            $ativo->valor_compra = 0;
            $ativo->valor_bruto = 0;
            $ativo->valor_liquido = 0;
        } else {
            $ativo->valor_compra = max(0,$valoresAtivo[0]['valor_compra']);  
        }
        if ($ativo->save()) {
            return true;
        } else {
            $this->erro = CajuiHelper::processaErros($ativo->getErrors());
            return false;
        }
    }
    
    
    public  function valorDeCompraEquantidade(){
                $venda = 0;
                $compra = 1;
        
                $quantidade_venda = Operacao::find()
                              ->select('sum(quantidade) as quantidade_venda')
                              ->andWhere(['ativo_id'=>$this->ativo_id])
                               ->andWhere(['tipo' => $venda]);
                
                $quantidade_compra = Operacao::find()
                              ->select('sum(quantidade) as quantidade_compra')
                              ->andWhere(['ativo_id'=>$this->ativo_id])
                               ->andWhere(['tipo' => $compra]);
                
                $valor_compra = Operacao::find()
                              ->select('sum(valor) as valor_compra')
                              ->andWhere(['ativo_id'=>$this->ativo_id])
                               ->andWhere(['tipo' => $compra]);
                
                $valor_venda = Operacao::find()
                              ->select('sum(valor) as  valor_venda')
                              ->andWhere(['ativo_id'=>$this->ativo_id])
                               ->andWhere(['tipo' => $venda]);
                
                $query =  (new Query())
                        ->select(['(coalesce(quantidade_compra,0)  - coalesce(quantidade_venda,0)) as quantidade',
                                  '(coalesce(valor_compra,0) - coalesce(valor_venda,0)) as valor_compra'])
                        ->from(['quantidade_venda'=>$quantidade_venda,
                                'quantidade_compra'=>$quantidade_compra,
                                'valor_venda'=>$valor_venda,
                                'valor_compra'=>$valor_compra]);
                        
                //echo $query->createCommand()->getRawSql();
                //exit();
                
               return $query->all();
                
                
        
       
    }
    
    
    public function getErro(){
        return $erro;
    }
    
    
    
}
