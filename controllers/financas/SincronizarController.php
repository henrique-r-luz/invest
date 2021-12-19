<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\financas;

use Yii;
use yii\web\Controller;
use app\lib\componentes\ExecutaBack;
use app\models\financas\AtualizaAcao;
use app\models\financas\service\sincroniza\CallScriptAcoes;
use app\models\financas\service\sincroniza\SincronizaFactory;

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
        $erro = '';

        if (Yii::$app->request->post('but') == 'backup') {
            return $this->executaBackup();
        }
        if (Yii::$app->request->post('but') == 'dados_empresa') {
            //a classe Runner deve ser extendida
            $runner = new ExecutaBack();
            $return = $runner->run('backgroud/atualiza-fundamento');
            Yii::$app->session->setFlash('success', 'Uma notificação será enviada quando o processo for finalizado!');
            return $this->redirect('index');
        }

        if (Yii::$app->request->post('but') == 'atualiza_dados') {
            $this->atualiza();
            
        }
    }
    

    private function atualiza()
    {
        SincronizaFactory::sincroniza('acao')->atualiza();
        SincronizaFactory::sincroniza('easy')->atualiza();
        //SincronizaFactory::sincroniza('operacaoClear')->atualiza();
        SincronizaFactory::sincroniza('banco_inter')->atualiza();
        Yii::$app->session->setFlash('success', 'Dados atualizados com sucesso!');
        return $this->redirect('/index.php');
        //return $this->redirect('/index.php');
    }

    /**
     * Faz backup do banco de dados do sistema
     */
    private function executaBackup()
    {
        $dump = Yii::$app->params['back_up'] . '/' . date("YmdHis") . '.sql';
        $cmd = 'sudo sshpass -p dandelo  ssh  henrique@' . Yii::$app->params['ip_docker'] . ' "docker exec ' . Yii::$app->params['container_web'] . ' pg_dump -U postgres  investimento" > ' . $dump;
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

    public function actionAtualizaDados(){
        $this->atualiza();
    }

    public function actionAtualizaAcoes()
    {
        unlink($this->local_file);
        $cmd = exec('python3.8 /var/www/invest/bot/acao.py > /dev/null 2>&1');
        echo true;
    }

    public function actionGetStatusAcoes()
    {
        try {
            $total = AtualizaAcao::find()->count();
            $arquivo =  file_get_contents($this->local_file);
            $ativoAtualizados = explode(';',$arquivo);
            foreach($ativoAtualizados as $item){
                $tipo  = explode('@#:',$item);
                if(isset($tipo[0]) && $tipo[0]=='erro'){
                    return $this->asJson(['ativosAtualizados'=>'erro','total'=>'erro']);
                }
            }
            return $this->asJson(['ativosAtualizados'=>(count($ativoAtualizados)-1),'total'=>($total+1)]);
        } catch (\Exception $e) {
            return $this->asJson(['ativosAtualizados'=>0,'total'=>0]);
        }
    }
}
