<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use Yii;
use app\lib\Categoria;
use app\lib\CajuiHelper;
use yii\base\UserException;
use app\models\financas\itensAtivo;
use app\models\financas\Operacao;
use app\models\financas\service\sincroniza\OperacoesAbstract;
use app\models\financas\service\sincroniza\ComponenteOperacoes;

/**
 * Description of CotacaoEasy
 *
 * @author henrique
 */
class CotacaoEasy extends OperacoesAbstract
{

    private $csv;

    //put your code here
    protected function getDados()
    {
        $file = Yii::$app->params['bot'] . '/Exportar_custodia.csv';
        if (!file_exists($file)) {
            //return [true, 'sucesso'];
        }
        $this->csv = array_map(function ($v) use ($file) {
            return str_getcsv($v, ComponenteOperacoes::getFileDelimiter($file));
        }, file($file));
        unset($this->csv[0]);
        unset($this->csv[1]);
    }

    public function atualiza()
    {
        $contErro = 0;
        $erros = '';
        foreach ($this->csv as $titulo) {
            $codigo = $titulo[1] . '-' . $titulo[3] . '-' . $titulo[2];
            $itensAtivos = ItensAtivo::find()
                ->joinWith(['ativos'])
                ->where(['codigo' => $codigo])->all();
            foreach ($itensAtivos as $itensAtivo) {
                if ($itensAtivo == null) {
                    $contErro++;
                    $erros .= ' o codigo do itensAtivo:' . $codigo . ' não existe</br>';
                } else {
                    $itensAtivo->valor_bruto = intval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[6]))));
                    $itensAtivo->valor_liquido = intval(str_replace(',', '.', str_replace('R$', '', str_replace('.', '', $titulo[7]))));
                    if ($itensAtivo->valor_compra <= 0 && $itensAtivo->quantidade > 0) {
                        $itensAtivo->valor_compra = $itensAtivo->valor_bruto;
                    }
                    if (!$itensAtivo->save()) {
                        $contErro++;
                        $erros .= CajuiHelper::processaErros($itensAtivo->getErrors()) . '</br>';
                    }
                }
            }
        }
        list($cont, $msg) = $this->atualizaBaby();
        $contErro += $cont;
        $erros .= $msg;
        if ($contErro != 0) {
            /* FabricaNotificacao::create('rank', ['ok' => false,
                'titulo' => 'Renda fixa Easynveste falhou!',
                'mensagem' => 'Renda fixa Easynveste não foi atualizados !</br>' . $erros,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();*/
            throw new UserException($erros);
        }
    }

    public function atualizaBaby()
    {
        $itensAtivos = ItensAtivo::find()
            ->joinWith(['ativos'])
            ->andWhere(['investidor_id' => 2])
            ->andWhere(['categoria' => Categoria::RENDA_FIXA])->all();
        $erros = '';
        foreach ($itensAtivos as $itensAtivo) {
            $compra = Operacao::find()
                ->where(['itens_ativos_id' => $itensAtivo->id])->sum('valor');

            $itensAtivo->valor_compra = $compra;
            $itensAtivo->valor_bruto = $compra;
            $itensAtivo->valor_liquido = $compra;
            if (!$itensAtivo->save()) {
                $erros .= CajuiHelper::processaErros($itensAtivo->getErrors()) . '</br>';
                return [1, $erros];
            }
        }
        return [0, $erros];
    }
}
