<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use \app\models\financas\Ativo;

/**
 * Description of DashBoardSearch
 *
 * @author henrique
 */
class DashBoardSearch {

    public function search() {
        $categorio = Ativo::find()
                ->select(['categoria', 'sum(valor_bruto) as valor_categoria'])
                ->groupBy(['categoria']);

        $tipo = Ativo::find()
                ->select(['tipo', 'sum(valor_bruto) as valor_tipo'])
                ->groupBy(['tipo']);

        $pais = Ativo::find()
                ->select(['pais', 'sum(valor_bruto) as valor_pais'])
                ->groupBy(['pais']);

        $valorTotal = Ativo::find()->select(['sum(valor_bruto) as valor_total']);

        $ativos = Ativo::find()
                ->select(['ativo.codigo', 'valor_bruto', 'ativo.categoria', 'valor_categoria', 'ativo.pais', 'valor_pais', 'ativo.tipo', 'valor_tipo'])
                // ->from(['valor_total'=>$valorTotal])
                ->innerJoin(['ativo_categoria' => $categorio], 'ativo.categoria = ativo_categoria.categoria')
                ->innerJoin(['ativo_tipo' => $tipo], 'ativo.tipo = ativo_tipo.tipo')
                ->innerJoin(['ativo_pais' => $pais], 'ativo.pais = ativo_pais.pais')
                ->where(['ativo' => true]);


        $dados = (new \yii\db\Query())
                ->from(['ativo' => $ativos, 'valorTotal' => $valorTotal])
                ->all();

        return $dados;
        
    }

}
