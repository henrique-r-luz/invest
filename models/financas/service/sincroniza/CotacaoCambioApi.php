<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use Yii;
use yii\base\UserException;
use app\models\financas\service\sincroniza\OperacoesAbstract;

/**
 * Description of CotacaoCambio
 *
 * @author henrique
 */
class CotacaoCambioApi extends OperacoesAbstract {

    //put your code here

    private $dados;

    public function atualiza() {
         try {
            $json = file_get_contents('https://economia.awesomeapi.com.br/last/USD-BRL');
            $this->data = json_decode($json, true);
            if (isset($this->data['USDBRL']['bid'])) {
                return $this->data['USDBRL']['bid'];
            } else {
                $this->erro('Os dados não puderam ser lidos! ');
            }
        } catch (\Exception $ex) {
            $this->erro($ex);
        }
    }

    public function getDados() {
        return true;
    }

    private function erro($erro) {
        $msg = 'A cotação do dolar não foi atualizada !</br>' . $erro;
        /*     'titulo' => 'Cotação do dolar falhou!',
            'mensagem' => $msg,
            'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();*/
        throw new UserException($msg);
    }

}
