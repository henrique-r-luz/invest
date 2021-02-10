<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;
use yii\base\Model;
use \app\models\financas\Ativo;
use \app\lib\Tipo;

/**
 * Description of LucroPrezuijo
 *
 * @author henrique
 */
class LucroPrezuijo extends Model{
    const verde = '#90ed7d';
    const vermelho = '#d70026';
    
    
    
    public function getDadosLucroPrejuizo(){
        $ativos = Ativo::find()
                  ->where(['ativo'=>true])
                  ->andWhere(['tipo'=> Tipo::ACOES])
                  ->orderBy(['(valor_bruto-valor_compra)'=>SORT_DESC])
                  ->all();
        return $this->criaDadosGrafico($ativos);
    }
    
    public function criaDadosGrafico($ativos){
        $dados = ['name'=>'Ações','data'=>[]];
        foreach($ativos as $ativo){
            $lucro = round($ativo->valor_bruto-$ativo->valor_compra);
            $cor = self::vermelho;
            if($lucro>=0){
                $cor = self::verde;
            } 
            $denominador =  1;
            if($ativo->valor_compra!=0){
                $denominador = $ativo->valor_compra;
            }
            $por = round((($ativo->valor_bruto-$ativo->valor_compra)/$denominador)*100);
            $dados['data'][] = ['name'=>$ativo->codigo,'y'=>$lucro,'por'=>$por,'color'=>$cor];
        }
        
       return $dados;
    }
    
}
