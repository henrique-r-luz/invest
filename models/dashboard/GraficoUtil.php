<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use yii\web\JsExpression;

/**
 * Description of GraficoUtil
 *
 * @author henrique
 */
class GraficoUtil {
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
    public static function dadosPizza($param){
        $vetDados = [];
         foreach ($param['dados'] as $item) {
            if ($item['valor_total'] > 0) {
                $vetDados[$item[$param['item']]] = round($item[$param['valor_item']] / $item[$param['valor_total']] * 100);
            }
        }
        arsort($vetDados);
        return $vetDados;
    }
    
    /**
   
     * @param type $param
     * @return \app\models\dashboard\JsExpression
     */
    public static function graficoPizza($dados){
        $grafico = [];
        $index = 0;
        foreach ($dados as $nome => $item) {
            $grafico[] = ['name' => $nome,
                'y' => $item,
                'color' => new JsExpression('Highcharts.getOptions().colors[' . $index . ']')
            ];
            $index++;
        }
        return $grafico;
    }
}
