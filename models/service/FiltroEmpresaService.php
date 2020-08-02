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
     * Deve retornar um array()
     */
    public function filtraAguiaConservador($params) {
      
        $dataNow = date('Y');
        $anoInicial = $dataNow-11;
        $contAnosBolsa = 10;
        $magenLiquidaMinima = 10;
        $dividaPorEdita = 3;
        $maximoCaixaNegativo = 2;
        $carregaGrid = $this->loadDadosGrid($params);
        
        
        //Filtro patrimonais
        $tempoBolsa = BalancoEmpresaBolsa::find()
                ->select(['codigo', 'count(codigo)'])
                ->andWhere(['trimestre' => false])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->groupBy(['codigo'])
                ->having(['<', 'count(codigo)', $contAnosBolsa]);

        $tempoBolsaCodigo = (new \yii\db\Query())
                ->select(['codigo'])
                ->from(['tempoBolsa'=>$tempoBolsa]);
        
        $contaFclCapexNegativo = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<', 'fcl_capex', 0])
                ->andWhere(['trimestre' => false])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->groupBy(['codigo'])
                ->having(['<=', 'count(codigo)', $maximoCaixaNegativo]);
        
         $FclCapexNegativo = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<', 'fcl_capex', 0])
                ->andWhere(['trimestre' => false])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->andWhere(['not in', 'acao_bolsa.codigo',  $contaFclCapexNegativo]);

        $lucroNegativo = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<=', 'lucro_liquido', 0])
                ->andWhere(['trimestre' => false])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial]);
        
         $ebitidaNegativo = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<=', 'ebitda', 0])
                ->andWhere(['trimestre' => false])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial]);

        $removeEmpresasComDivida = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['>=', 'divida_liquida_ebitda', $dividaPorEdita])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->andWhere(['trimestre' => false]);

        
        $removeMargemLiquidaPequena = BalancoEmpresaBolsa::find()
                ->select(['codigo'])
                ->where(['<', 'margem_liquida', $magenLiquidaMinima])
                ->andWhere([">=", "split_part(data, '-', 1)", $anoInicial])
                ->andWhere(['trimestre' => false]);

        $filtro = BalancoEmpresaBolsa::find()
                ->select(['acao_bolsa.codigo', 'acao_bolsa.nome', 'cnpj', 'setor'])
                ->distinct()
                ->innerJoin('acao_bolsa', 'acao_bolsa.codigo = balanco_empresa_bolsa.codigo');
        
        
       

        if (!empty($this->filtroEmpresa->id)) {
            $filtro->where(['not in', 'acao_bolsa.codigo', $lucroNegativo])
                    ->andWhere(['not in', 'acao_bolsa.codigo', $removeEmpresasComDivida])
                    ->andWhere(['not in', 'acao_bolsa.codigo', $ebitidaNegativo])
                    ->andWhere(['not in', 'acao_bolsa.codigo',  $tempoBolsaCodigo])
                    ->andWhere(['not in','acao_bolsa.codigo',$removeMargemLiquidaPequena])
                    ->andWhere(['not in', 'acao_bolsa.codigo', $FclCapexNegativo])
                    ->andWhere(['not ilike', 'acao_bolsa.setor', new \yii\db\Expression("'%banco%'")]);// remove bancos
                    
        }


        if ($carregaGrid) {
            $filtro->andFilterWhere(['ilike', 'acao_bolsa.cnpj', $this->filtroEmpresaDados->cnpj]);
            $filtro->andFilterWhere(['ilike', 'acao_bolsa.codigo', $this->filtroEmpresaDados->codigo]);
            $filtro->andFilterWhere(['ilike', 'acao_bolsa.nome', $this->filtroEmpresaDados->nome]);
            $filtro->andFilterWhere(['ilike', 'acao_bolsa.setor', $this->filtroEmpresaDados->setor]);
        }

        return $filtro->asArray()->all();



     
    }

    function getFiltroEmpresa() {
        return $this->filtroEmpresa;
    }

    function getFiltroEmpresaDados() {
        return $this->filtroEmpresaDados;
    }

}
