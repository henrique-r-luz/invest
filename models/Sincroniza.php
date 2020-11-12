<?php
namespace app\models;

use app\models\AcaoBolsa;
use app\models\Ativo;
use app\models\Operacao;
use Exception;
use SplFileObject;
use app\lib\CajuiHelper;

use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Sincroniza extends \yii\base\Model
{
    
    public function cotacaoAcao() {
        //$json = file_get_contents('url_here');
        //$obj = json_decode($json);
        //echo $obj->access_token;
        $cambio = $this->cotacaoCambio();
      
        $contErro = 0;
        $erros = '';
        $file = Yii::$app->params['bot'].'/preco_acao.csv';
        if (!file_exists($file)) {
            return [true, 'sucesso'];
        }
        $csv = array_map('str_getcsv', file($file));
        $newkeys = array('id', 'valor');
        foreach ($csv as $id => $linha) {
            $csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }
        unset($csv[0]);
        foreach ($csv as $acoe) {
            $ativo = Ativo::findOne($acoe['id']);
            $valor = str_replace('.', '', $acoe['valor']);
            $valor = str_replace(',', '.', $valor);
            $valor = Ativo::valorCambio($ativo, $valor);
           
            $lucro = ($valor * $ativo->quantidade);
            $ativo->valor_bruto = $lucro;
            $ativo->valor_liquido = $lucro;
            $valorCompra = Ativo::valorCambio($ativo,Operacao::valorDeCompra($acoe['id']));
            $ativo->valor_compra =$valorCompra; 
            
            if (!$ativo->save()) {
                $erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
                $contErro++;
            }
        }
        if ($contErro == 0) {
            return [true, 'sucesso'];
        } else {
            return [false, 'erro:</br>' . $erros];
        }
    }
    
    
    public function cotacaoCambio(){
        
       
        $file = Yii::$app->params['bot'].'/cambio.csv';
        if (!file_exists($file)) {
            throw new Exception("Não foi possível encontrar o arquivo de câmbio");
        }
        $csv = array_map('str_getcsv', file($file));
        unset($csv[0]);
       
        $cambio = [];
        foreach ($csv as $moeda) {
           $cambio[$moeda[0]]=$moeda[1];
        }
        return $cambio;
      
    }

    public function empresas() {
        $erros = '';
        $file = Yii::$app->params['bot'].'/empresa.csv';
        if (!file_exists($file)) {
            return [true, 'sucesso'];
        }
        $csv = array_map('str_getcsv', file($file));
        $newkeys = array('cnpj', 'codigo', 'nome', 'setor');
        foreach ($csv as $id => $linha) {
            $csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }
        unset($csv[0]);
        $contErro = 0;
        foreach ($csv as $acoe) {
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

    public function easy() {
        $erros = '';
        $file = Yii::$app->params['bot'].'/Exportar_custodia.csv';
        if (!file_exists($file)) {
            //return [true, 'sucesso'];
        }
        $csv = array_map(function($v)use($file) {
            return str_getcsv($v,  $this->getFileDelimiter($file));
        }, file($file));
        unset($csv[0]);
        unset($csv[1]);

       
        $contErro = 0;
        foreach ($csv as $titulo) {
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

    public function clearAcoes() {
        /*
         * 1-> codigo ativo; 
         * 8-> quantidade 
         * 10-> preço médio unitario
         * 11-> data da operação
         * 15-> cancelado por
         * tipo = 1 compra
         */
        $arquivo = Yii::$app->params['bot'].'/orders.csv';
        $erros = 'Erro na criação das Operações: ';
        if (!file_exists($arquivo)) {
            return [true, 'sucesso'];
        }
        //$csv = array_map('str_getcsv', file('/vagrant/bot/orders.csv'));
        $csv = array_map(function($v)use($arquivo) {
            return str_getcsv($v, $this->getFileDelimiter($arquivo));
        }, file($arquivo));
        unset($csv[0]);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($csv as $id => $linha) {
              
                $codigo = substr($linha[1], 0, 5); //str_replace("F", "", $linha[1]);
                $ativo = Ativo::find()
                        ->where(['codigo' => $codigo])
                        ->one();
                List($data, $hora) = explode(" ", $linha[11]);
                List($d, $m, $y) = explode('/', $data);
                $dataAcao = $y . '-' . $m . '-' . $d . ' ' . $hora;

                if (Operacao::find()->where(['ativo_id' => $ativo->id])->andWhere(['data' => $dataAcao])->exists()) {
                    continue;
                }

                if ($ativo != null && ($linha[15] == '' || $linha[15] == null)) {

                    $operacao = new Operacao();
                    $operacao->ativo_id = $ativo->id;
                    $operacao->quantidade = $linha[8];
                    $operacao->data = $dataAcao;
                    $operacao->valor = $linha[10] * $linha[8];
                    $operacao->tipo = 1;

                    if (!$operacao->salvaOperacao()) {

                        $transaction->rollBack();
                        $erros .= CajuiHelper::processaErros($operacao->getErrors()) . '</br>';

                        return [false, $erros];
                    }
                }
            }
            $transaction->commit();
            return [true, 'sucesso'];
        } catch (Exception $e) {
            $transaction->rollBack();
            return [false, $erros . $e];
            throw $e;
        }
    }

    private function getFileDelimiter($file, $checkLines = 2) {
        $file = new SplFileObject($file);
        $delimiters = array(',', '\t', ';', '|', ':');
        $results = array();
        $i = 0;
        while ($file->valid() && $i <= $checkLines) {
            $line = $file->fgets();
            foreach ($delimiters as $delimiter) {
                $regExp = '/[' . $delimiter . ']/';
                $fields = preg_split($regExp, $line);
                if (count($fields) > 1) {
                    if (!empty($results[$delimiter])) {
                        $results[$delimiter]++;
                    } else {
                        $results[$delimiter] = 1;
                    }
                }
            } $i++;
        } $results = array_keys($results, max($results));
        return $results[0];
    }
        
}

