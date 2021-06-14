<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\lib\CajuiHelper;
use app\lib\componentes\FabricaNotificacao;
use app\models\financas\Ativo;
use app\models\financas\Operacao;
use Yii;
use yii\db\Exception;
use \app\lib\Categoria;
use yii\base\UserException;
use \app\lib\Tipo;
use \app\lib\Pais;

/**
 * Description of CotacoesAcao
 *
 * @author henrique
 */
class CotacoesAcaoApi extends OperacoesAbstract {

    private $key = '58RJ9L0YB6SYKV5G';

    //put your code here
    public function atualiza() {
        set_time_limit(6000);
        $this->contacaoAcoesBrasil();
        $this->cotacaoAtivosUsa();
        $this->atualizaFiis();
    }

    private function contacaoAcoesBrasil() {
        $ativos = Ativo::find()->where(['ativo' => true])
                ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
                ->andWhere(['pais' => Pais::BR])
                ->andWhere(['tipo' => Tipo::ACOES])
                ->all();
        foreach ($ativos as $acoes) {
            try {
                $url = "https://api.hgbrasil.com/finance/stock_price?key=e94e8fa6&symbol=" . $acoes->codigo;
                $json = file_get_contents($url);
                $dados = json_decode($json, true);
                $preco = 0;
                if (isset($dados['results'][$acoes->codigo]['price'])) {
                    $preco = $dados['results'][$acoes->codigo]['price'];
                } else {
                    $this->erro('Os dados não puderam ser lidos! ' . $acoes->codigo . ' ' . $url);
                }
            } catch (Exception $ex) {
                $this->erro('<b> Ação ' . $acao->codigo . ' <b>: ' . $ex);
            }
            $this->salvaValorCompraAtivo($acoes, $preco);
        }
    }

    private function cotacaoAtivosUsa() {
        $ativos = Ativo::find()->where(['ativo' => true])
                ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
                ->andWhere(['pais' => Pais::US])
                ->all();
        $empresas = [];
        foreach ($ativos as $acoes) {
            $empresas[] = $acoes->codigo;
        }
        try {
            $context = stream_context_create(array(
                'http' => array('ignore_errors' => true),
            ));
            $url = "https://mboum.com/api/v1/qu/quote/?symbol=" . implode(',', $empresas) . "&apikey=Niy1I9fd7L8GmG3v8Eot3CHYC1o7mxINKbN90IPvdmCuHqB8kKiVJsByOCeX";
            $json = file_get_contents($url, false, $context);
            $dados = json_decode($json, true);
            $index = 0;
            //print_r($dados);
            //exit();
            foreach ($dados as $acoes) {


                if (isset($acoes['ask'])) {
                    $preco = $acoes['ask'];
                } else {
                    $this->erro('Os dados não puderam ser lidos! ' . $ativos[$index]->codigo . ' ' . $url);
                }
                $this->salvaValorCompraAtivo($ativos[$index], $preco);
                $index++;
            }
        } catch (Exception $ex) {
            $this->erro('<b> Ação ' . $acoes['symbol'] . ' <b>: ' . $ex);
        }
    }

    private function atualizaFiis() {
        $ativos = Ativo::find()->where(['ativo' => true])
                ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
                ->andWhere(['pais' => Pais::BR])
                ->andWhere(['tipo' => Tipo::FIIS])
                ->all();
        foreach ($ativos as $acoes) {
            try {
                $url = "https://www.alphavantage.co/query?function=GLOBAL_QUOTE&symbol=" . $acoes->codigo . ".SAO" . "&apikey=" . $this->key;
                $json = file_get_contents($url);
                $dados = json_decode($json, true);
                $preco = 0;
                if (isset($dados['Global Quote']['05. price'])) {
                    $preco = $dados['Global Quote']['05. price'];
                } else {
                    print_r($dados);
                    exit();
                    $this->erro('Os dados não puderam ser lidos! ' . $acoes->codigo . ' ' . $url);
                }
            } catch (Exception $ex) {
                $this->erro('<b> Ação ' . $acao->codigo . ' <b>: ' . $ex);
            }
            $this->salvaValorCompraAtivo($acoes, $preco);
        }
    }

    private function salvaValorCompraAtivo($acoes, $preco) {
        $ativo = Ativo::findOne($acoes->id);
        $valor = Ativo::valorCambio($ativo, $preco);

        $lucro = ($valor * $ativo->quantidade);
        $ativo->valor_bruto = $lucro;
        $ativo->valor_liquido = $lucro;
        $valorCompra = Ativo::valorCambio($ativo, Operacao::valorDeCompra($acoes->id));
        $ativo->valor_compra = $valorCompra;

        if (!$ativo->save()) {
            $erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
            $this->erro('<b> Ação ' . $acao->codigo . ' <b>: ' . $erros);
        }
    }

    private function erro($erro) {
        $msg = 'Cotações das ações não foram atualizadas !</br>' . $erro;
        FabricaNotificacao::create('rank', ['ok' => false,
            'titulo' => 'Cotações das ações falharam!',
            'mensagem' => $msg,
            'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
        throw new UserException($msg);
    }

    public function getDados() {

        return true;
    }

}
