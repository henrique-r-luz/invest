<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\analiseGrafica;

use app\lib\Categoria;
use app\models\financas\Proventos;
use yii\base\Model;

/**
 * Description of LucroPrezuijo
 *
 * @author henrique
 */
class ProventosPorAtivos extends Model{
    const verde = '#90ed7d';
    const vermelho = '#d70026';
    
    
    
    public function getDadosProventos(){
        $ativos = Proventos::find()
                  ->innerjoin('ativo','ativo.id = proventos.ativo_id')
                  ->select(['ativo.codigo','sum(valor) as valor'])
                  ->where(['ativo'=>true])
                  ->andWhere(['categoria'=> Categoria::RENDA_VARIAVEL])
                  ->groupBy(['ativo.codigo'])
                  ->orderBy(['sum(valor)'=>SORT_DESC])
                  ->asArray()
                  ->all();
       
        return $this->criaDadosGrafico($ativos);
    }
    
    public function criaDadosGrafico($ativos){
        $dados = ['name'=>'Ativos','data'=>[]];
        foreach($ativos as $ativo){
            $lucro = round($ativo['valor']);
            $cor = self::verde;
            $dados['data'][] = ['name'=>$ativo['codigo'],'y'=>$lucro,'color'=>$cor];
        }
        
       return $dados;
    }
    
}
