<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\config\ValorDollar;
use app\lib\dicionario\Pais;
use yii\web\JsExpression;

/**
 * Description of GraficoUtil
 *
 * @author henrique
 */
class GraficoUtil
{
    //put your code here


    /**
     * estrutura de $param
     * [
     *  'dados'=>dados recuperados do banco de dados,
     *  'valor_total'=> patrimônio total,
     *   'item'=>informação que será mostrada no gráfico exemplo(país, ativo, categoria, tipo e etc)
     *   'valor_item'=> valor total do item mostrado, 
     * ]
     * @param type $param
     */
    public static function dadosPizza($param)
    {

        //divide Dados por pais
        $infos = self::constroiDadosPorPais($param);
        //soma os dados com o cambio
        $vetDados  = self::addvalorCambio($infos);
        $vetDados = self::geraPorcentagem($vetDados, $param);
        arsort($vetDados);
        return $vetDados;
    }


    private static function constroiDadosPorPais($param)
    {
        $infos = [];
        foreach ($param['dados'] as $item) {
            //print_r($param['dados']);
            //exit();
            if ($param['valorInvestido'] > 0) {
                $infos[$item[$param['item']]][$item['pais']] = $item[$param['valor_item']];
                // $vetDados[$item[$param['item']]] = round($item[$param['valor_item']] / $param['valorInvestido'] * 100);
            }
        }
        return $infos;
    }

    private static  function addvalorCambio($infos)
    {
        $vetDados = [];
        foreach ($infos as $key => $info) {
            $vetDados[$key] = 0;
            foreach ($info as $pais => $valores) {
                if ($pais == Pais::US) {
                    $vetDados[$key] += ($valores * ValorDollar::getCotacaoDollar());
                } else {
                    $vetDados[$key] += $valores;
                }
            }
        }
        return $vetDados;
    }

    private static function geraPorcentagem($vetDados, $param)
    {
        $aux = [];
        foreach ($vetDados as $key => $valor) {
            if ($param['valorInvestido'] == 0) {
                $param['valorInvestido'] = 1;
            }
            $aux[$key] = round(($valor / ($param['valorInvestido']) * 100));
        }
        return $aux;
    }

    /**
   
     * @param type $param
     * @return \app\models\dashboard\JsExpression
     */
    public static function graficoPizza($dados)
    {
        $grafico = [];
        $index = 0;
        foreach ($dados as $nome => $item) {
            $grafico[] = [
                'name' => $nome,
                'y' => $item,
                'color' => new JsExpression('Highcharts.getOptions().colors[' . $index . ']')
            ];
            $index++;
        }
        return $grafico;
    }
}
