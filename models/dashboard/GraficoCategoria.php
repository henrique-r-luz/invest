<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\Categoria;
use yii\web\JsExpression;

/**
 * Description of GraficoCategoria
 *
 * @author henrique
 */
class GraficoCategoria {

    //put your code here

    private $dados;
    private $rendaFixa;
    private $rendaVariavel;
    private $valorTotalPatrimonio;

    function __construct($dados) {
        $this->dados = $dados;
        $this->configuraDados();
    }

    private function configuraDados() {
        $rendaFixa = 0;
        $valorTotalPatrimonio = 0;
        $rendaVariavel = 0;
        foreach ($this->dados as $item) {
            if ($item['categoria'] == Categoria::RENDA_FIXA) {
                $rendaFixa = $item['valor_categoria'];
                $valorTotalPatrimonio = $item['valor_total'];
                break;
            }
        }

        foreach ($this->dados as $item) {
            if ($item['categoria'] == Categoria::RENDA_VARIAVEL) {
                $rendaVariavel = $item['valor_categoria'];
                break;
            }
        }
        if ($valorTotalPatrimonio == 0) {

            $this->rendaFixa = 0;
            $this->rendaVariavel = 0;
            $this->valorTotalPatrimonio = 0;
            return;
        }
        $this->rendaFixa = round(($rendaFixa / $valorTotalPatrimonio) * 100);
        $this->rendaVariavel = round(($rendaVariavel / $valorTotalPatrimonio) * 100);
        $this->valorTotalPatrimonio = $valorTotalPatrimonio;

    }

    public function montaGrafico() {
        return [
            [
                'name' => 'Renda Fixa',
                'y' => $this->rendaFixa,
                'color' => new JsExpression('Highcharts.getOptions().colors[0]'),
            ],
            [
                'name' => 'Renda Variável',
                'y' => $this->rendaVariavel,
                'color' => new JsExpression('Highcharts.getOptions().colors[1]'),
            ],
        ];
       
    }

}
