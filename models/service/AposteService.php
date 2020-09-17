<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\service;

use app\lib\Pais;
use app\lib\Tipo;
use app\models\Aporte;
use app\models\Ativo;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;

/**
 * Description of AposteService
 *
 * @author henrique
 */
class AposteService {

    //put your code here


    private $post;
    private $aporte;
    private $model;
    private $provider;

    function __construct() {
        $this->aporte = new Aporte();
    }

    public function load($post) {
        $this->post = $post;
        return $this->aporte->load(Yii::$app->request->post());
    }

    public function acoesAporte() {
        $ativos = $this->getDados();
        $model = [];
        foreach ($ativos as $ativo) {
            $valorTotal = $ativo['soma_valor_bruto'] + $this->aporte->valor;
            $parcela = $valorTotal / $ativo['total_acao'];
            $model[] = ['Ativo' => $ativo['codigo'], 'Quantidade' => round((($parcela - $ativo['valor_bruto'])/$ativo['preco'])), 'Valor' =>round(($parcela - $ativo['valor_bruto']),2)];
        }
        $this->model = $model;
        $this->provider = new ArrayDataProvider([
            'allModels' => $model,
            'pagination' => false
        ]);
      
    }

    private function getDados() {


        $somas = Ativo::find()
                ->select([
                    'sum(valor_bruto) as soma_valor_bruto',
                    'count(id) as total_acao'
                ])
                ->where(['tipo' => Tipo::ACOES])
                ->andWhere(['pais' => Pais::BR])
                ->andWhere(['ativo' => true]);
        if (!empty($this->aporte->ativo)) {
            $somas->andWhere(['not in', 'id', $this->aporte->ativo]);
        }


        $ativo = (new Query)
                ->select(['id',
                    'codigo',
                    'quantidade',
                    'valor_bruto',
                    'soma_valor_bruto',
                    'total_acao',
                    '(valor_bruto/quantidade) as preco'
                ])
                ->from(['somas' => $somas, 'ativo'])
                ->where(['tipo' => Tipo::ACOES])
                ->andWhere(['ativo' => true])
                ->andWhere(['pais' => Pais::BR]);
        if (!empty($this->aporte->ativo)) {
            $ativo->andWhere(['not in', 'id', $this->aporte->ativo]);
        }
        $ativo->orderBy(['valor_bruto' => SORT_ASC])
                ->indexBy(['id']);
               

        return $ativo->all();
       
    }

    function getAporte() {
        return $this->aporte;
    }

    function getModel() {
        return $this->model;
    }

    function getProvider() {
        return $this->provider;
    }

    function setModel($model) {
        $this->model = $model;
    }

}
