<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\financas;

use app\lib\componentes\ExecutaBack;
use Yii;
use yii\web\Controller;
use \app\models\financas\service\sincroniza\SincronizaFactory;

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

        if (Yii::$app->request->post('but') == 'backup') {
            return $this->executaBackup();
        }
        if (Yii::$app->request->post('but') == 'cotacao_empresa') {
            
            SincronizaFactory::sincroniza('acao')->atualiza();
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
            SicronizaFactory::sicroniza('easy')->atualiza();
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
            /*list($resp, $msg) = $sicroniza->empresas();
            $erro .= $msg;
            if ($resp) {
                Yii::$app->session->setFlash('success', 'Os dados das empresas do site do Eduardo foram atualizadas!');
                return $this->render('index');
            } else {
                Yii::$app->session->setFlash('danger', $erro);
                return $this->render('index');
            }*/
        }
    }

    /**
     * Faz backup do banco de dados do sistema
     */
    private function executaBackup() {
        $dump = '/vagrant/invest/back/investimento_' . date("YmdHis") . '.sql';
        $cmd = 'sudo -u postgres pg_dump investimento  > ' . $dump;
        $resp = shell_exec($cmd);
        if (empty($resp)) {
            if (file_exists($dump)) {
                Yii::$app->session->setFlash('success', 'O Backup realizado com sucesso!');
                return $this->render('index');
            } else {
                Yii::$app->session->setFlash('danger', 'O arquivo não foi criado.');
                return $this->render('index'); 
            }
        } else {
            Yii::$app->session->setFlash('danger', 'Erro ao realizar backup.');
            return $this->render('index');
        }
    }

}
