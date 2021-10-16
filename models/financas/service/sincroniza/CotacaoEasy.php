<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use app\lib\CajuiHelper;
use app\lib\Categoria;
use app\lib\componentes\FabricaNotificacao;
use app\models\financas\Ativo;
use app\models\financas\Operacao;
use Yii;
use yii\base\UserException;

/**
 * Description of CotacaoEasy
 *
 * @author henrique
 */
class CotacaoEasy extends OperacoesAbstract {

    private $csv;

    //put your code here
    protected function getDados() {
        $file = Yii::$app->params['bot'] . '/Exportar_custodia.csv';
        if (!file_exists($file)) {
            //return [true, 'sucesso'];
        }
        $this->csv = array_map(function($v)use($file) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($file));
        }, file($file));
        unset($this->csv[0]);
        unset($this->csv[1]);
    }

    public function atualiza() {
        $contErro = 0;
        $erros = '';
        foreach ($this->csv as $titulo) {
            $codigo = $titulo[1] . '-' . $titulo[3] . '-' . $titulo[2];
            $ativo = Ativo::find()->where(['codigo' => $codigo])->one();
            if ($ativo == null) {
                $erros .= ' o codigo do ativo:' . $codigo . ' não existe</br>';
            } else {
                $ativo->valor_bruto = str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[6])));
                $ativo->valor_liquido = str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[7])));
                if ($ativo->valor_compra <= 0 && $ativo->quantidade > 0) {
                    $ativo->valor_compra = $ativo->valor_bruto;
                }
                if (!$ativo->save()) {
                    $contErro++;
                    $erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
                }
            }
        }
        List($cont, $msg) = $this->atualizaBaby();
        $contErro += $cont;
        $erros .= $msg;
        if ($contErro != 0) {
            FabricaNotificacao::create('rank', ['ok' => false,
                'titulo' => 'Renda fixa Easynveste falhou!',
                'mensagem' => 'Renda fixa Easynveste não foi atualizados !</br>' . $erros,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
            throw new UserException($erros);
        }
    }

    public function atualizaBaby() {
        $ativos = Ativo::find()
                        ->andWhere(['investidor_id' => 2])
                        ->andWhere(['categoria' => Categoria::RENDA_FIXA])->all();
        $erros = '';
        foreach ($ativos as $ativo) {
            $compra = Operacao::find()
                            ->where(['ativo_id' => $ativo->id])->sum('valor');

            $ativo->valor_compra = $compra;
            $ativo->valor_bruto = $compra;
            $ativo->valor_liquido = $compra;
            if (!$ativo->save()) {
                $erros .= CajuiHelper::processaErros($ativo->getErrors()) . '</br>';
                return [1, $erros];
            }
        }
        return [0, $erros];
    }

}
