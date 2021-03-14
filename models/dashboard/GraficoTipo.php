<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use yii\web\JsExpression;

/**
 * Description of GraficoTipo
 *
 * @author henrique
 */
class GraficoTipo extends GraficoAbstract {

    //put your code here

    private $tipos = [];

    protected function configuraDados() {
        $this->tipos = GraficoUtil::dadosPizza(['dados'=>$this->dados,
                                                 'item'=>'tipo',
                                                 'valor_item'=>'valor_tipo',
                                                'valor_total'=>'valor_total']);
    }

    public function montaGrafico() {     
     return GraficoUtil::graficoPizza($this->tipos);

    }

}
