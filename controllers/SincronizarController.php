<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;


use app\lib\componentes\ExecutaBack;
use \app\models\Sincroniza;
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
        $sicroniza = new Sincroniza();
        $erro = '';
        
         if (Yii::$app->request->post('but') == 'backup') {
             $this->executaBackup();
         }
        if (Yii::$app->request->post('but') == 'cotacao_empresa') {
            list($resp, $msg) = $sicroniza->cotacaoAcao();
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
            list($resp, $msg) = $sicroniza->easy();
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
            list($resp, $msg) = $sicroniza->empresas();
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
    
    /**
     * Faz backup do banco de dados do sistema
     */
    private function executaBackup(){
       $cmd =  'sudo -u postgres pg_dump investimento  > /vagrant/invest/back/investimento_'.date("YmdHis").'.sql';
      // echo $cmd;
    }

    

}
