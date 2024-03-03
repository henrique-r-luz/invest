<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\sincronizar;

use Yii;
use Throwable;
use yii\web\Controller;
use app\lib\helpers\InvestException;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;

/**
 * Description of SincronizarController
 *
 * @author henrique
 */
class SincronizarController extends Controller
{

    public $processed = 0;

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionSincroniza()
    {


        if (Yii::$app->request->post('but') == 'atualiza_dados') {
            $this->atualiza();
        }

        if (Yii::$app->request->post('but') == 'recalcula_ativos') {
            $this->recalculaAtivos();
        }
    }


    private function atualiza()
    {
        try {
            $atualizaRendaVariavel = new AtualizaRendaVariavel();
            $atualizaRendaVariavel->alteraIntesAtivo();
            Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso!');
            return $this->redirect('/index.php');
        } catch (InvestException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado.');
        } finally {
            return $this->redirect('/index.php');
        }
    }


    private function recalculaAtivos()
    {
        try {
            $atualizaRendaVariavel = new RecalculaAtivos();
            $atualizaRendaVariavel->alteraIntesAtivo();
            Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso!');
        } catch (InvestException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado.');
        } finally {
            return $this->redirect('/index.php');
        }
        return $this->redirect('/index.php');
    }
}
