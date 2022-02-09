<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use \app\models\financas\Ativo;
use app\lib\Tipo;
use \app\models\financas\Proventos;

/**
 * Description of DashBoardSearch
 *
 * @author henrique
 */
class DashBoardSearch
{

        public function search()
        {
                $categorio = Ativo::find()
                        ->select(['categoria', 'sum(valor_bruto) as valor_categoria'])
                        ->joinWith(['itensAtivo'])
                        ->where(['ativo' => true])
                        ->groupBy(['categoria']);

                $tipo = Ativo::find()
                        ->select(['tipo', 'sum(valor_bruto) as valor_tipo'])
                        ->joinWith(['itensAtivo'])
                        ->where(['ativo' => true])
                        ->groupBy(['tipo']);

                $pais = Ativo::find()
                        ->select(['pais', 'sum(valor_bruto) as valor_pais'])
                        ->joinWith(['itensAtivo'])
                        ->where(['ativo' => true])
                        ->groupBy(['pais']);

                $acaoPais = Ativo::find()
                        ->select(['tipo,pais,sum(valor_bruto) as valor_acao_pais'])
                        ->joinWith(['itensAtivo'])
                        ->where(['tipo' => Tipo::ACOES])
                        ->andWhere(['ativo' => true])
                        ->groupBy(['tipo', 'pais']);




                $valorTotal = Ativo::find()
                        ->select([
                                'sum(valor_bruto) as valor_total',
                                'sum(valor_compra) as valor_compra'
                        ])
                        ->joinWith(['itensAtivo'])
                        ->where(['ativo' => true]);


                $ativos = Ativo::find()
                        ->select([
                                'ativo.codigo', 'sum(valor_bruto) as valor_bruto', 'ativo.categoria',
                                'valor_categoria',
                                'ativo.pais', 'valor_pais', 'ativo.tipo',
                                'valor_tipo', 'valor_acao_pais'
                        ])
                        ->joinWith(['itensAtivo'])
                        ->leftJoin(
                                ['ativo_categoria' => $categorio],
                                'ativo.categoria = ativo_categoria.categoria'
                        )
                        ->leftJoin(['ativo_tipo' => $tipo], 'ativo.tipo = ativo_tipo.tipo')
                        ->leftJoin(['ativo_pais' => $pais], 'ativo.pais = ativo_pais.pais')
                        ->leftJoin(['ativo_acao_pais' => $acaoPais], 'ativo_acao_pais.pais = ativo.pais')
                        ->where(['ativo' => true])
                        ->groupBy([
                                'ativo.codigo', 'ativo.categoria', 'valor_categoria',
                                'ativo.pais', 'valor_pais', 'ativo.tipo', 'valor_tipo', 'valor_acao_pais'
                        ]);


                $dados = (new \yii\db\Query())
                        ->from(['ativo' => $ativos, 'valorTotal' => $valorTotal])
                        ->all();
                //echo $dados->createCommand()->getRawSql();                
                //exit();       
                return $dados;
        }
}
