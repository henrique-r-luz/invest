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
        $tipo = array_unique(array_column($this->dados, 'tipo'));
        $this->tipos = GraficoUtil::dadosPizza(['dados' => $this->dados,
                    'item' => 'tipo',
                    'valor_item' => 'valor_tipo',
                    'valor_total' => 'valor_total']);

        unset($this->tipos['Ações']);
        $paises = [\app\lib\Pais::BR, \app\lib\Pais::US];
        foreach ($paises as $pais) {
            foreach ($this->dados as $dados) {
                if ($dados['pais'] == $pais && $dados['tipo'] == \app\lib\Tipo::ACOES) {
                    if ($dados['valor_total'] > 0) {
                        $this->tipos['Ações-' . $pais] = round($dados['valor_acao_pais'] / $dados['valor_total'] * 100);
                    }
                    break;
                }
            }
        }
        asort($this->tipos);
    }

    public function montaGrafico() {
        return GraficoUtil::graficoPizza($this->tipos);
    }

}
