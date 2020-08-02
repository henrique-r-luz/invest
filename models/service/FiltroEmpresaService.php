<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use \app\models\BalancoEmpresaBolsa;
use \app\models\AcaoBols;
use app\models\FiltroEmpresa;
use \app\models\FiltroEmpresaDados;
use \app\lib\TipoFiltro;
use Yii;

/**
 * Description of FiltroEmpresaService
 *
 * @author henrique
 */
class FiltroEmpresaService {

    //put your code here
    private $filtroEmpresa;
    private $filtroEmpresaDados;

    public function __construct() {
        $this->filtroEmpresa = new FiltroEmpresa();
        $this->filtroEmpresaDados = new FiltroEmpresaDados();
    }

    public function load($post) {
        $session = Yii::$app->session;
        $retorno = $this->filtroEmpresa->load($post);
        return $retorno;
    }

    public function loadDadosGrid($post) {
        return $this->filtroEmpresaDados->load($post);
    }

    /**
     * define qual filtro vai ser utilizado
     */
    public function fabricaFiltro($params) {
        if (!empty($this->filtroEmpresa)) {
            switch ($this->filtroEmpresa->id) {
                case TipoFiltro::AGUIA_CONSERVADOR:
                   return $this->filtraAguiaConservador($params);
                case 1:
                    echo "i equals 1";
                    break;
                case 2:
                    echo "i equals 2";
                    break;
            }
        }
        return [];
    }

    /**
     * Filtra empresas com a técnica do investidor Aguia.
     * de forma conservadora.  
     * 
     * Deve retornar um array()
     */
    public function filtraAguiaConservador($params) {
        $anoInicial = '2008';
        $contAnosBolsa = 10;
        $carregaGrid = $this->loadDadosGrid($params);


        $lucroNegativo = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<=', 'lucro_liquido', 0])
                ->andWhere(['trimestre' => false])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial]);

        $removeEmpresasComDivida = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['>', 'divida_liquida_ebitda', 3])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->andWhere(['trimestre' => false]);

        $removeBasileiaRuim = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<', 'indice_basileia', 11])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->andWhere(['trimestre' => false]);

        $filtro = BalancoEmpresaBolsa::find()
                ->select(['acao_bolsa.codigo', 'acao_bolsa.nome', 'cnpj', 'setor'])
                ->distinct()
                ->innerJoin('acao_bolsa', 'acao_bolsa.codigo = balanco_empresa_bolsa.codigo');

        if (!empty($this->filtroEmpresa->id)) {
            $filtro->where(['not in', 'acao_bolsa.codigo', $lucroNegativo])
                    ->andWhere(['not in', 'acao_bolsa.codigo', $removeEmpresasComDivida])
                    ->andWhere(['not in', 'acao_bolsa.codigo', $removeBasileiaRuim]);
        }
                
        
        if($carregaGrid){
           $filtro->andFilterWhere(['ilike', 'acao_bolsa.cnpj', $this->filtroEmpresaDados->cnpj]);
           $filtro->andFilterWhere(['ilike', 'acao_bolsa.codigo', $this->filtroEmpresaDados->codigo]);
           $filtro->andFilterWhere(['ilike', 'acao_bolsa.nome', $this->filtroEmpresaDados->nome]);
           $filtro->andFilterWhere(['ilike', 'acao_bolsa.setor', $this->filtroEmpresaDados->setor]);
        }
                
        return $filtro->asArray()->all();

       

        // echo $filtro->createCommand()->getRawSql();
        //  exit();
    }

    function getFiltroEmpresa() {
        return $this->filtroEmpresa;
    }

    function getFiltroEmpresaDados() {
        return $this->filtroEmpresaDados;
    }

}
