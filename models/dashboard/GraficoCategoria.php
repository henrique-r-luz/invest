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
class GraficoCategoria extends GraficoAbstract
{


    private $renda;


    protected function configuraDados()
    {

        $this->renda = GraficoUtil::dadosPizza([
            'dados' => $this->dados,
            'item' => 'categoria',
            'valor_item' => 'valor_categoria',
            'valor_total' => 'valor_total',
            'valorAporte' => $this->valorAporte,
            'valorInvestido' => $this->valorInvestido,
        ]);
    }

    public function montaGrafico()
    {
        return GraficoUtil::graficoPizza($this->renda);
    }
}
