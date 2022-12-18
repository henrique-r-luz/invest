<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\dashboard;

use app\lib\config\ValorDollar;
use yii\web\JsExpression;
use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use app\models\dashboard\GraficoUtil;
use app\models\dashboard\GraficoAbstract;

/**
 * Description of GraficoTipo
 *
 * @author henrique
 */
class GraficoTipo extends GraficoAbstract
{

    //put your code here

    private $tipos = [];

    protected function configuraDados()
    {
        $tipo = array_unique(array_column($this->dados, 'tipo'));
        $this->tipos = GraficoUtil::dadosPizza([
            'dados' => $this->dados,
            'item' => 'tipo',
            'valor_item' => 'valor_tipo',
            'valor_total' => 'valor_total',
            'valorAporte' => $this->valorAporte,
            'valorInvestido' => $this->valorInvestido,
        ]);

        unset($this->tipos['Ações']);
        $paises = [Pais::BR, Pais::US];
        foreach ($paises as $pais) {
            foreach ($this->dados as $dados) {
                if ($dados['pais'] == $pais && $dados['tipo'] == Tipo::ACOES) {
                    if ($this->valorInvestido > 0) {
                        if ($pais == Pais::US) {
                            $this->tipos['Ações-' . $pais] = round(($dados['valor_acao_pais'] * ValorDollar::getCotacaoDollar()) / $this->valorInvestido * 100);
                        } else {
                            $this->tipos['Ações-' . $pais] = round(($dados['valor_acao_pais']) / $this->valorInvestido * 100);
                        }
                    }
                    break;
                }
            }
        }
        asort($this->tipos);
    }

    public function montaGrafico()
    {

        return GraficoUtil::graficoPizza($this->tipos);
    }
}
