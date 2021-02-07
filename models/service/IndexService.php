<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\lib\Categoria;
use app\lib\componentes\FabricaNotificacao;
use app\lib\Pais;
use app\lib\Tipo;
use app\models\financas\Ativo;
use Yii;
use yii\web\JsExpression;
use app\models\financas\service\sincroniza\SincronizaFactory;

/**
 * Description of IndexService
 *
 * @author henrique
 */
class IndexService {

    //put your code here


    private $dadosCategoria;
    private $dadosPais;
    private $dadosAtivo;
    private $dadosTipo;
    private $dadosAcaoes;
    private $patrimonioBruto;
    private $valorCompra;
    private $lucro;
    private $dadosAcaoPais;

    function __construct() {
        
    }

    public function sincroniza() {
        SincronizaFactory::sincroniza('easy')->atualiza();
        SincronizaFactory::sincroniza('operacaoClear')->atualiza();
        SincronizaFactory::sincroniza('acao')->atualiza();
        //SincronizaFactory::sincroniza('banco_inter')->atualiza();
    }

    public function createGraficos() {
        $this->sincroniza();
        $totalPatrimonio = Ativo::find()
                ->andWhere(['>', 'quantidade', 0])
                 ->andWhere(['ativo' => true])
                ->sum('valor_bruto');

        $ativos = Ativo::find()
                ->orderBy(['valor_bruto' => SORT_DESC])
                 ->andWhere(['ativo' => true])
                ->andWhere(['>', 'quantidade', 0])
                ->all();
        
        
          $acoes = Ativo::find()
                ->where(['tipo' => Tipo::ACOES])
                ->andWhere(['>', 'quantidade', 0])
                ->andWhere(['<>', 'valor_bruto', 0])
                   ->andWhere(['ativo' => true])
                ->orderBy(['valor_bruto' => SORT_DESC])
                ->all();
          
          
        $totalAcoes = Ativo::find()
                ->where(['tipo' => Tipo::ACOES])
                 ->andWhere(['ativo' => true])
                ->sum('valor_bruto');

        //gráfico por categorias
        $this->dadosCategoria = [];
        $this->graficoCategoria($totalPatrimonio, $this->dadosCategoria);

        //gráfico por tipo
        $this->dadosAtivo = [];
        $this->graficoTipo($ativos, $totalPatrimonio, $this->dadosTipo);

        //grafico por País
        $this->dadosPais = [];
        $this->graficoPais($totalPatrimonio, $this->dadosPais);
        
        $this->graficoAcaoPais($totalAcoes, $this->dadosAcaoPais);

        //grafico por ativo
        foreach ($ativos as $id => $ativo) {
            $fatia = [];
            $valorAtivo = $ativo->valor_liquido;
            $fatia['name'] = $ativo->codigo;
            if ($totalPatrimonio == 0) {
                $totalPatrimonio = 1;
            } else {
                $fatia['y'] = round((($valorAtivo / $totalPatrimonio) * 100));
            }
            $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $id . ']');
            $this->dadosAtivo[] = $fatia;
        }
        //gráfico de ações ações
        $this->dadosAcoes = [];
      
        foreach ($acoes as $id => $acao) {
            $fatia = [];
            $valorAtivo = $acao->valor_liquido;
            $fatia['name'] = $acao->codigo;
            if ($totalPatrimonio == 0) {
                $totalPatrimonio = 1;
            } else {
                $fatia['y'] = round((($valorAtivo / $totalAcoes) * 100));
            }
            $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $id . ']');
            $this->dadosAcaoes[] = $fatia;
        }


        //patrimônio bruto total
        $this->patrimonioBruto = Ativo::find()
                ->andWhere(['ativo' => true])
                ->sum('valor_bruto');

        $somaCompra = Ativo::find()
                ->andWhere(['ativo' => true])
                ->sum('valor_compra');
        //valor de compra

        $this->lucro = $this->patrimonioBruto - $somaCompra;
        $formatter = \Yii::$app->formatter;
        $this->lucro = $formatter->asCurrency($this->lucro);
        $formatter = \Yii::$app->formatter;
        $this->valorCompra = $formatter->asCurrency($somaCompra);
        $formatter = \Yii::$app->formatter;
        $this->patrimonioBruto = $formatter->asCurrency($this->patrimonioBruto);
    }


    private function montaGraficoCategoria($categoria, $totalPatrimonio, $cor, &$dadosCategoria) {
        $fatia = [];
        $valorAtivoCategoria = Ativo::find()->where(['categoria' => $categoria])
                 ->andWhere(['ativo' => true])
                ->sum('valor_bruto');
        $fatia['name'] = $categoria;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoCategoria / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosCategoria[] = $fatia;
    }

    private function montaGraficoPais($pais, $totalPatrimonio, $cor, &$dadosPais) {
        $fatia = [];
        $valorAtivoPais = Ativo::find()->where(['pais' => $pais])
                 ->andWhere(['ativo' => true])
                ->sum('valor_bruto');
        $fatia['name'] = $pais;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoPais / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosPais[] = $fatia;
    }
    
    

    private function montaGraficoTipo($tipo, $totalPatrimonio, $cor, &$dadosTipo) {
        $fatia = [];
        $valorAtivoCategoria = Ativo::find()->where(['tipo' => $tipo])
                 ->andWhere(['ativo' => true])
                ->sum('valor_bruto');
        $fatia['name'] = $tipo;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoCategoria / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosTipo[] = $fatia;
    }
    
     private function montaGraficoAcaoPais($pais, $totalPatrimonio, $cor, &$dadosAcaoPais) {
        $fatia = [];
        
        $valorAtivoPais = Ativo::find()->where(['pais' => $pais])
                 ->andWhere(['tipo' => Tipo::ACOES])
                 ->andWhere(['ativo' => true])
                ->sum('valor_bruto');
        $fatia['name'] = $pais;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoPais / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosAcaoPais[] = $fatia;
    }

    private function graficoPais($totalPatrimonio, &$dadosPais) {
        $this->montaGraficoPais(Pais::BR, $totalPatrimonio, 0, $dadosPais);
        $this->montaGraficoPais(Pais::US, $totalPatrimonio, 1, $dadosPais);
    }
    
    
    private function graficoCategoria($totalPatrimonio, &$dadosCategoria) {
        $this->montaGraficoCategoria(Categoria::RENDA_FIXA, $totalPatrimonio, 0, $dadosCategoria);
        $this->montaGraficoCategoria(Categoria::RENDA_VARIAVEL, $totalPatrimonio, 1, $dadosCategoria);
    }

    private function graficoTipo($ativos, $totalPatrimonio, &$dadosTipo) {


        $dadosTipo = [];
        $this->montaGraficoTipo(Tipo::ACOES, $totalPatrimonio, 0, $dadosTipo);
        $this->montaGraficoTipo(Tipo::CDB, $totalPatrimonio, 1, $dadosTipo);
        $this->montaGraficoTipo(Tipo::DEBENTURES, $totalPatrimonio, 2, $dadosTipo);
        $this->montaGraficoTipo(Tipo::FUNDOS_INVESTIMENTO, $totalPatrimonio, 3, $dadosTipo);
        $this->montaGraficoTipo(Tipo::TESOURO_DIRETO, $totalPatrimonio, 4, $dadosTipo);
        $this->montaGraficoTipo(Tipo::Criptomoeda, $totalPatrimonio, 5, $dadosTipo);
    }
    
    private function graficoAcaoPais($totalPatrimonio, &$dadosAcaoPais){
        $this->montaGraficoAcaoPais(Pais::BR, $totalPatrimonio, 0, $dadosAcaoPais);
        $this->montaGraficoAcaoPais(Pais::US, $totalPatrimonio, 1, $dadosAcaoPais);
    }

    function getDadosCategoria() {
        return $this->dadosCategoria;
    }

    function getDadosPais() {
        return $this->dadosPais;
    }

    function getDadosAtivo() {
        return $this->dadosAtivo;
    }

    function getDadosTipo() {
        return $this->dadosTipo;
    }

    function getDadosAcaoes() {
        return $this->dadosAcaoes;
    }

    function getPatrimonioBruto() {
        return $this->patrimonioBruto;
    }

    function getValorCompra() {
        return $this->valorCompra;
    }

    function getLucro() {
        return $this->lucro;
    }
    
    function getDadosAcaoPais() {
        return $this->dadosAcaoPais;
    }



}
