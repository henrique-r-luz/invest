<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\lib\CajuiHelper;
use app\lib\componentes\ExecutaBack;
use app\models\AcaoBolsa;
use app\models\Ativo;
use app\models\Operacao;
use Exception;
use SplFileObject;
use Yii;
use yii\web\Controller;

/**
 * Description of SincronizarController
 *
 * @author henrique
 */
class SincronizarController extends Controller {

    public $processed = 0;

    public function actionIndex() {

        return $this->render('index');
    }

    public function actionSincroniza() {

        $erro = '';
        if (Yii::$app->request->post('but') == 'cotacao_empresa') {
            list($resp, $msg) = $this->cotacaoAcao();
            $erro .= $msg;
            if ($resp) {
                Yii::$app->session->setFlash('success', 'A cotação das ações foram atualizadas!');
                return $this->render('index');
            } else {
                Yii::$app->session->setFlash('danger', $erro);
                return $this->render('index');
            }
        }
        if (Yii::$app->request->post('but') == 'titulo') {
            list($resp, $msg) = $this->easy();
            $erro .= $msg;
            if ($resp) {
                Yii::$app->session->setFlash('success', 'Os dados da Easynvest foram atualizados !');
                return $this->render('index');
            } else {
                Yii::$app->session->setFlash('danger', $erro);
                return $this->render('index');
            }
        }
        if (Yii::$app->request->post('but') == 'dados_empresa') {

            //a classe Runner deve ser extendida
            $runner = new ExecutaBack();
            $return = $runner->run('backgroud/atualiza-fundamento');
            Yii::$app->session->setFlash('success', 'Uma notificação será enviada quando o processo for finalizado!');
            return $this->redirect('index');
        }

        if (Yii::$app->request->post('but') == 'empresa') {
            list($resp, $msg) = $this->empresas();
            $erro .= $msg;
            if ($resp) {
                Yii::$app->session->setFlash('success', 'Os dados das empresas do site do Eduardo foram atualizadas!');
                return $this->render('index');
            } else {
                Yii::$app->session->setFlash('danger', $erro);
                return $this->render('index');
            }
        }
    }

    public function cotacaoAcao() {
        $contErro = 0;
        $erros = '';
        $file = '/vagrant/bot/preco_acao.csv';
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
//$output = shell_exec("/home/vagrant/anaconda3/bin/python3.6 /vagrant/bot/acao.py " . $acoe . " 2>&1");
            $valor = str_replace(',', '.', $acoe['valor']);
            $lucro = ($valor * $ativo->quantidade);
            $ativo->valor_bruto = $lucro;
            $ativo->valor_liquido = $lucro;
            if ($ativo->valor_compra <= 0 && $ativo->quantidade > 0) {
                $ativo->valor_compra = $ativo->valor_bruto;
            }

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

    public function empresas() {
        $erros = '';
        $file = '/vagrant/bot/empresa.csv';
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
        $file = '/vagrant/bot/Exportar_custodia.csv';
        if (!file_exists($file)) {
            //return [true, 'sucesso'];
        }
        $csv = array_map(function($v)use($file) {
            return str_getcsv($v,  $this->getFileDelimiter($file));
        }, file($file));
        unset($csv[0]);
        unset($csv[1]);

        $id = 0;
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
            $id++;
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
        $arquivo = '/vagrant/bot/orders.csv';
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
