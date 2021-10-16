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
use app\models\financas\service\OperacaoService;
use Yii;
use yii\base\UserException;
use yii\db\Exception;

/**
 * Description of OperacaoClear
 *
 * @author henrique
 */
class OperacaoClear extends OperacoesAbstract {

    //put your code here

    private $csv;

    protected function getDados() {
        $arquivo = Yii::$app->params['bot'] . '/orders.csv';

        $erros = 'Erro na criação das Operações: ';
        if (!file_exists($arquivo)) {
            return [true, 'sucesso'];
        }
        //$csv = array_map('str_getcsv', file('/vagrant/bot/orders.csv'));
        $this->csv = array_map(function($v)use($arquivo) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($arquivo));
        }, file($arquivo));
        unset($this->csv[0]);
    }

    public function atualiza() {
        $transaction = Yii::$app->db->beginTransaction();

        try {
            foreach ($this->csv as $id => $linha) {

                $codigo = substr($linha[1], 0, 5); //str_replace("F", "", $linha[1]);
                $ativo = Ativo::find()
                        ->where(['codigo' => $codigo])
                        ->one();
                if (empty($ativo)) {
                    $codigo = $linha[1]; //str_replace("F", "", $linha[1]);
                    $ativo = Ativo::find()
                            ->where(['codigo' => $codigo])
                            ->one();
                    if (empty($ativo)) {
                        continue;
                    }
                }
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
                    if (trim(strtolower($linha[3])) == 'venda') {
                        $operacao->tipo = 0;
                    } else {
                        $operacao->tipo = 1;
                    }
                    $operacaoService = new OperacaoService($operacao);
                    if (!$operacaoService->acaoSalvaOperacao()) {

                        $transaction->rollBack();
                        $erros .= CajuiHelper::processaErros($operacaoService->getOpereacao()->getErrors()) . '</br>';
                        throw new UserException($erros);
                    }
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            if ($resp == false) {
              /*  FabricaNotificacao::create('rank', ['ok' => false,
                    'titulo' => 'Operações ações Falhou!',
                    'mensagem' => 'As operações de ações Falharam !.<br>' . $erros,
                    'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();*/
                throw new UserException($erros);
            }

            $transaction->rollBack();
        }
    }

}
