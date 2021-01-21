<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\lib\CajuiHelper;
use app\models\financas\Ativo;
use Yii;

/**
 * Description of CotacaoEasy
 *
 * @author henrique
 */
class CotacaoEasy extends OperacoesAbstract {

    private $csv;

    //put your code here
    protected function getDados() {
        $file = Yii::$app->params['bot'] . '/Exportar_custodia.csv';
        if (!file_exists($file)) {
            //return [true, 'sucesso'];
        }
        $this->csv = array_map(function($v)use($file) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($file));
        }, file($file));
        unset($this->csv[0]);
        unset($this->csv[1]);
    }

    public function atualiza() {
        $contErro = 0;
        $erros = '';
        foreach ($this->csv as $titulo) {
            // echo $titulo[1].'-'.$titulo[3].'-'.$titulo[2].'</br>';
            $ativo = Ativo::find()->where(['codigo' => $titulo[1] . '-' . $titulo[3] . '-' . $titulo[2]])->one();
            $ativo->valor_bruto = str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[6])));
            $ativo->valor_liquido = str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[7])));
            if ($ativo->valor_compra <= 0 && $ativo->quantidade > 0) {
                $ativo->valor_compra = $ativo->valor_bruto;
            }
            if (!$ativo->save()) {
                $contErro++;
                $erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
            }
        }
        //exit();
        if ($contErro == 0) {
            return [true, 'sucesso'];
        } else {
            return [false, $erros];
        }
    }

}
