<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use app\lib\CajuiHelper;
use app\lib\componentes\Util;
use app\models\AcaoBolsa;
use Phpml\Regression\LeastSquares;
use Yii;
/**
 * Description of GeraRank
 *
 * @author henrique
 */
class AcaoBolsaOperacao {

    //put your code here

    public static function geraRankMinQuad($dadosEmpresas,$atribute) {
        $resp = [];
        $dados = [];
        foreach ($dadosEmpresas as $empresa) {
            $atributos = array_keys($empresa);
            $numerador = 0;
            $denominador = 1;
            for ($i = 1; $i < sizeof($atributos); $i++) {
                $samples = [];
                $targets = Util::convertArrayAgregInVetor($empresa[$atributos[$i]]);
                $j = 1;
                foreach ($targets as $item) {
                    $samples[] = [$j];
                    $j++;
                }
                $regression = new LeastSquares();
                $regression->train($samples, $targets);
                $dados[$empresa[$atributos[0]]][$atributos[$i]] = $regression->getCoefficients()[0];
                $numerador += $regression->getCoefficients()[0] * (isset(Util::NUMERADOR[$atributos[$i]]) ? Util::NUMERADOR[$atributos[$i]] : 0);
                $denominador += $regression->getCoefficients()[0] * (isset(Util::DENOMINADOR[$i]) ? Util::DENOMINADOR[$atributos[$i]] : 0);
            }
            $acaoBolsa = AcaoBolsa::find()->where(['codigo' => $empresa[$atributos[0]]])->one();
            
            $acaoBolsa->{$atribute} = abs(round($numerador / $denominador) / 1000);
          //  $date = new DateTime();
            $date = date('Y-m-d H:i:s',time());
            $acaoBolsa->data_atualizacao_rank = $date;
            if (!$acaoBolsa->save()) {
                $resp = [false,('Erro ao atualizar Rank anual!</br>' . CajuiHelper::processaErros($acaoBolsa->getErrors()))];
                return $resp;
            }
        }
        return [true,'Rank atualizado!'];
    }

}
