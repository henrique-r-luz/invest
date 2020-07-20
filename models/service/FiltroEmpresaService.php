<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\models\service;

use  \app\models\BalancoEmpresaBolsa;
use \app\models\AcaoBols;
use app\models\FiltroEmpresa;
/**
 * Description of FiltroEmpresaService
 *
 * @author henrique
 */
class FiltroEmpresaService {
    //put your code here
    
     private $empresasBolsa;
     private $empresas;
     private $filtroEmpresa;
    
    
    public function __construct() {
       // $this->empresasBolsa = new BalancoEmpresaBolsa();
       // $this->empresas = new AcaoBolsa();
        $this->filtroEmpresa = new FiltroEmpresa();
    }
    
    
    public function load($post){
        return $this->filtroEmpresa->load($post);
    }
    
    /**
     * Filtra empresas com a técnica do investidor Aguia.
     * de forma conservadora.  
     */
    public function filtraAguiaConservador(){
        $lucroNegativo = BalancoEmpresaBolsa::find()
                                                    ->select(['codigo'])
                                                    ->where(['<=','lucro_liquido',0])
                                                    ->andWhere(['trimestre'=>false]);
        
        $removeEmpresasComDivida = BalancoEmpresaBolsa::find()
                                                    ->select(['codigo'])
                                                    ->where(['>','divida_liquida_ebitda',3])
                                                    ->andWhere(['trimestre'=>false]);
        
        $removeBasileiaRuim = BalancoEmpresaBolsa::find()
                                                    ->select(['codigo'])
                                                    ->where(['<','indice_basileia',11])
                                                    ->andWhere(['trimestre'=>false]);
        
        $filtro = BalancoEmpresaBolsa::find()
                ->select(['acao_bolsa.codigo','acao_bolsa.nome','cnpj','setor'])
                ->distinct()
                ->innerJoin('acao_bolsa','acao_bolsa.codigo = balanco_empresa_bolsa.codigo')
                ->where(['not in', 'acao_bolsa.codigo',$lucroNegativo])
                ->andWhere(['not in', 'acao_bolsa.codigo',$removeEmpresasComDivida])
                ->andWhere(['not in', 'acao_bolsa.codigo',$removeBasileiaRuim]);
        
        return $filtro->asArray()->all();
        //echo $filtro->createCommand()->getRawSql();
        //exit();
    }
    
    function getFiltroEmpresa() {
        return $this->filtroEmpresa;
    }


   
}
