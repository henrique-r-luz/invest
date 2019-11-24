<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\web\Controller;
use \app\models\Ativo;
use Yii;
use \app\models\AcaoBolsa;
use app\lib\CajuiHelper;
use \app\models\Operacao;

/**
 * Description of SicronizarController
 *
 * @author henrique
 */
class SicronizarController extends Controller {

    public $processed = 0;

//put your code here
//mapeamento id do ativo com índice do objeto easy 
    const discionario = [
        0 => 1, //Tesouro Selic 2023
        1 => 3, //Tesouro IPCA+ 2024
        2 => 4, //Tesouro Selic 2025
        3 => 5, //BANCO AGIBANK
        4 => 6, //BANCO AGIBANK
        5 => 2, //CMDT23 - CEMIG DISTRIBUICAO S.A
        6 => 7, //MDT23 - CEMIG DISTRIBUICAO S.A
        7 => 9, //BANCO MAXIMA
        8 => 10, //BANCO MAXIMA
        9 => 11, //BANCO MAXIMA
        10 => 12, //DEVANT SOLIDUS CASH FIRF CP
    ];

    public function actionIndex() {

        return $this->render('index');
    }

    public function actionSicroniza() {
        set_time_limit(3600);
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
            echo 'dados_empresa';
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
        $csv = array_map('str_getcsv', file('/vagrant/bot/preco_acao.csv'));
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
        $csv = array_map('str_getcsv', file('/vagrant/bot/empresas.csv'));
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
        $csv = array_map('str_getcsv', file('/vagrant/bot/easy.csv'));
        $newkeys = array('nome', 'valor_bruto', 'valor_liquido');
        foreach ($csv as $id => $linha) {
            $csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }
        unset($csv[0]);
        $contErro = 0;
        $id = 0;
        foreach ($csv as $acoe) {

            $ativo = Ativo::findOne(self::discionario[$id]);
            $ativo->valor_bruto = str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $acoe['valor_bruto'])));
            $ativo->valor_liquido = str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $acoe['valor_liquido'])));
            if ($ativo->valor_compra <= 0 && $ativo->quantidade > 0) {
                $ativo->valor_compra = $ativo->valor_bruto;
            }
            if (!$ativo->save()) {
                $contErro++;
                $erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
            }
            $id++;
        }

        if ($contErro == 0) {
            return [true, 'sucesso'];
        } else {
            return [false, $erros];
        }
    }

}
