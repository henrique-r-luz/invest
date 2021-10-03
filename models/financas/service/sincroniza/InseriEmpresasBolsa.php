<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\lib\CajuiHelper;
use app\models\financas\AcaoBolsa;

/**
 * Description of InseriEmpresasBolsa
 *
 * @author henrique
 */
class InseriEmpresasBolsa extends OperacoesAbstract {

    private $csv;
    
    //put your code here
    protected function getDados() {
         if (!file_exists($file)) {
            return [true, 'sucesso'];
        }
        $this->csv = array_map('str_getcsv', file($file));
        $newkeys = array('cnpj', 'codigo', 'nome', 'setor');
        foreach ($csv as $id => $linha) {
            $this->csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }
        unset($this->csv[0]);
    }

    public function atualiza() {
        $erros = '';
        $contErro = 0;
         foreach ($this->csv as $acoe) {
            $acaoBolsa = AcaoBolsa::find()
                    ->where(['cnpj' => $acoe['cnpj']])
                    ->one();
            if ($acaoBolsa == null) {
                $acaoBolsa = new AcaoBolsa();
                $acaoBolsa->cnpj = $acoe['cnpj'];
                $acaoBolsa->codigo = $acoe['codigo'];
                $acaoBolsa->nome = $acoe['nome'];
                $acaoBolsa->setor = $acoe['setor'];
                if (!$acaoBolsa->save()) {
                    $erros .= CajuiHelper::processaErros($acaoBolsa->getErrors()) . '</br>';
                    $contErro++;
                }
            }
        }
        if ($contErro == 0) {
            return [true, 'sucesso'];
        } else {
            return [false, $erros];
        }
       
    }

}
