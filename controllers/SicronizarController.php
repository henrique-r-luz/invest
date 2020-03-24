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
use \app\models\BalancoEmpresaBolsa;

/**
 * Description of SicronizarController
 *
 * @author henrique
 */
class SicronizarController extends Controller {

    public $processed = 0;

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
        if (!file_exists('/vagrant/bot/preco_acao.csv')) {
            return [true, 'sucesso'];
        }
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
        if (!file_exists('/vagrant/bot/empresa.csv')) {
            return [true, 'sucesso'];
        }
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
        if (!file_exists('/vagrant/bot/Exportar_custodia.csv')) {
            //return [true, 'sucesso'];
        }
        $csv = array_map(function($v) {
            return str_getcsv($v, ";");
        }, file('/vagrant/bot/Exportar_custodia.csv'));
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
        $erros = 'Erro na criação das Operações: ';
        if (!file_exists('/vagrant/bot/orders.csv')) {
            return [true, 'sucesso'];
        }
        //$csv = array_map('str_getcsv', file('/vagrant/bot/orders.csv'));
        $csv = array_map(function($v) {
            return str_getcsv($v, ";");
        }, file('/vagrant/bot/orders.csv'));
        unset($csv[0]);
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($csv as $id => $linha) {
                $codigo = str_replace("F", "", $linha[1]);

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
        } catch (\Exception $e) {
            $transaction->rollBack();
            return [false, $erros . $e];
            throw $e;
        }
    }

    public function fundamentos() {
        
        $erros = 'Erro na criação dos balanços : ';
        if (!file_exists('/vagrant/bot/fundamentos.csv')) {
            return [false, 'sucesso'];
        }
        $old = ini_set('memory_limit', '8192M');
        $csv = array_map('str_getcsv', file('/vagrant/bot/fundamentos.csv'));

        foreach ($csv as $id => $linha) {
            //ajusta dados
            if ($id == 0) {
                continue;
            }
            foreach ($linha as $k => $valor) {
                if ($valor == 's/n') {
                    $csv[$id][$k] = null;
                }
                if ($valor == 'P') {
                    $csv[$id][$k] = null;
                }
                $csv[$id][$k] = $valor = str_replace('%', '', $csv[$id][$k]);
                $csv[$id][$k] = $valor = str_replace('.', '', $csv[$id][$k]);
                $csv[$id][$k] = $valor = str_replace(',', '.', $csv[$id][$k]);
            }
        }

        $newkeys = $csv[0];
        foreach ($csv as $id => $linha) {
            $csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }

        unset($csv[0]);




        foreach ($csv as $id => $linha) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $anoVar = str_replace(' ', '', $linha['Ano']);

                List($mes, $ano) = explode("/", $anoVar);
                $anoVar = $ano . '-' . $mes;
                $linha['Ano'] = $anoVar;
                $linha['trimestre'] = ($linha['trimestre']=='True')?1:0;
                $linha['empresa'] = substr(trim($linha['empresa']), 0, 4);
                $balanco = BalancoEmpresaBolsa::find()->where(['codigo' => $linha['empresa']])
                                ->andWhere(['data' => $linha['Ano'],'trimestre'=>$linha['trimestre']])->one();
                if ($balanco != null) {
                    $balanco = $this->constroiData($balanco, $linha);
                    //continue;
                } else {
                    $balanco = new BalancoEmpresaBolsa();
                    $balanco = $this->constroiData($balanco, $linha);
                }
                if (!$balanco->save()) {
                    $transaction->rollBack();
                    $erros .= CajuiHelper::processaErros($balanco->getErrors()) . '</br>';

                    return [false, $erros];
                }
                $transaction->commit();
            } catch (\Exception $e) {
                $transaction->rollBack();
                return [false, $erros . $e];
                throw $e;
            }
        }
        return [true, 'sucesso'];
    }

    public function constroiData($balanco, $linha) {

        $balanco->data = $linha['Ano'];
        $balanco->patrimonio_liquido = $linha['Pat. Líq.'] == 's/n' ? null : $linha['Pat. Líq.'];
        $balanco->receita_liquida = $linha['Receita Líq.'] == 's/n' ? null : $linha['Receita Líq.'];
        $balanco->ebitda = $linha['EBITDA'] == 's/n' ? null : $linha['EBITDA'];
        $balanco->ebit = null;
        $balanco->margem_ebit = null;
        $balanco->resultado_financeiro = $linha['Res. Fin.'] == 's/n' ? null : $linha['Res. Fin.'];
        $balanco->imposto = null;
        $balanco->lucro_liquido = $linha['Lucro Líq.'] == 's/n' ? null : $linha['Lucro Líq.'];

        $balanco->margem_liquida = $linha['Mrg. Líq.'] == 's/n' ? null : $linha['Mrg. Líq.'];
        $balanco->roe = $linha['ROE'] == 's/n' ? null : $linha['ROE'];
        $balanco->caixa = $linha['Caixa'] == 's/n' ? null : $linha['Caixa'];
        $balanco->divida_bruta = $linha['Dívida'];
        $balanco->divida_liquida = null;
        $balanco->divida_bruta_patrimonio = null;
        $balanco->divida_liquida_ebitda = $linha['D. L. / EBITDA'] == 's/n' ? null : $linha['D. L. / EBITDA'];
        $balanco->fco = $linha['FCO'] == 's/n' ? null : $linha['FCO'];
        $balanco->capex = $linha['CAPEX'] == 's/n' ? null : $linha['CAPEX'];
        $balanco->fcf = $linha['FCF'] == 's/n' ? null : $linha['FCF'];
        $balanco->fcl = '';
        $balanco->fcl_capex = $linha['FCL CAPEX'] == 's/n' ? null : $linha['FCL CAPEX'];
        $balanco->proventos = $linha['Prov.'] == 's/n' ? null : $linha['Prov.'];
        $balanco->payout = $linha['Payout'] == 's/n' ? null : $linha['Payout'];
        $balanco->pdd = $linha['PDD'] == 's/n' ? null : $linha['PDD'];

        $balanco->pdd_lucro_liquido = $linha['PDD/Lucro Líquido'] == 's/n' ? null : $linha['PDD/Lucro Líquido'];
        $balanco->indice_basileia = $linha['Índice de Basiléia'] == 's/n' ? null : $linha['Índice de Basiléia'];
        $balanco->codigo = substr(trim($linha['empresa']), 0, 4);
        $balanco->trimestre = $linha['trimestre'];
        // echo 
        return $balanco;
    }

}
