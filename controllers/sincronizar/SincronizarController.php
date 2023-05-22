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
use app\models\sincronizar\AtualizaAcao;
use app\models\sincronizar\services\AddPreco;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

/**
 * Description of SincronizarController
 *
 * @author henrique
 */
class SincronizarController extends Controller
{

    public $processed = 0;
    private $local_file = '/var/www/dados/atualiza_acao.txt';

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionSincroniza()
    {

        if (Yii::$app->request->post('but') == 'dados_empresa') {
            //a classe Runner deve ser extendida
            return $this->redirect('index');
        }

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
    }

    /**
     * Atualiza a tabela de preços através do Javascript
     *
     * @return void
     * @author Henrique Luz
     */
    public function actionAtualizaDadosJs()
    {
        try {
            $addPreco = new AddPreco();
            $addPreco->salva();
            $this->atualiza();
        } catch (InvestException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
            return $this->render('index');
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('danger', 'Um erro inesperado ocorreu.');
            return $this->render('index');
        }
    }
    /**
     * inicia o porcesso de atualização de ações 
     * utilizado o servidor selenium
     *
     * @return void
     * @author Henrique Luz
     */
    public function actionAtualizaAcoes()
    {
        if (file_exists($this->local_file)) {
            unlink($this->local_file);
        }
        $cmd = exec('python3 /var/www/bot/acao.py > /dev/null 2>&1 &');
        echo true;
    }
    /**
     * Faz a contabilidade de quais ações foram 
     * atualizadas pelo selenium
     *
     * @return void
     * @author Henrique Luz
     */
    public function actionGetStatusAcoes()
    {
        try {
            $total = AtualizaAcao::find()->count();
            $arquivo =  file_get_contents($this->local_file);
            $ativoAtualizados = explode(';', $arquivo);
            foreach ($ativoAtualizados as $item) {
                $tipo  = explode('@#:', $item);
                if (isset($tipo[0]) && $tipo[0] == 'erro') {
                    return $this->asJson(['ativosAtualizados' => 'erro', 'total' => 'erro']);
                }
            }
            return $this->asJson(['ativosAtualizados' => (count($ativoAtualizados) - 1), 'total' => ($total)]);
        } catch (Throwable) {
            return $this->asJson(['ativosAtualizados' => 0, 'total' => 0]);
        }
    }
}
