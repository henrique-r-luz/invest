<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use yii\web\JsExpression;

/**
 * Description of GraficoPais
 *
 * @author henrique
 */
class GraficoPais extends GraficoAbstract
{

    //put your code here

    private $pais = [];

    protected function configuraDados()
    {

        $this->pais = GraficoUtil::dadosPizza([
            'dados' => $this->dados,
            'item' => 'pais',
            'valor_item' => 'valor_pais',
            'valor_total' => 'valor_total',
            'valorAporte' => $this->valorAporte,
            'valorInvestido' => $this->valorInvestido,
        ]);
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->pais);
    }
}
