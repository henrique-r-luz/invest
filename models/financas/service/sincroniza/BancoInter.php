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
use Smalot\PdfParser\Parser;
use Yii;
use yii\base\UserException;

/**
 * Description of BancoInter
 *
 * @author henrique
 */
class BancoInter extends OperacoesAbstract {

    private $valorCdbBruto;
    private $valorCdbLiquido;
    private $cdbBancoInterId = 33;
    private $erros;

    //put your code here
    protected function getDados() {
        $parser = new Parser();
        $pdf = $parser->parseFile(Yii::$app->params['bot'] . '/banco_inter.pdf');
        $text = $pdf->getText();
        $valores = $this->between('TOTAL', 'POUPANÇA', $text);
        $valores = preg_replace('/[ ]{2,}|[\t]/', '@', trim($valores));
        $valores = explode('@', trim($valores));
        $this->valorCdbBruto = str_replace('.', '', $valores[count($valores) - 3]);
        $this->valorCdbBruto = str_replace(',', '.', $this->valorCdbBruto);
        $this->valorCdbLiquido = str_replace('.', '', $valores[count($valores) - 1]);
        $this->valorCdbLiquido = str_replace(',', '.', $this->valorCdbLiquido);
    }

    public function atualiza() {
        $cdbBancoInter = Ativo::findOne($this->cdbBancoInterId);
        $cdbBancoInter->valor_bruto = $this->valorCdbBruto;
         $cdbBancoInter->valor_liquido = $this->valorCdbLiquido;
        if (!$cdbBancoInter->save()) {
            $this->erros .= CajuiHelper::processaErros($cdbBancoInter->getErrors()) . '</br>';
            $msg = 'A sicronização CDB banco Inter falhou!</br>' . $this->erros;
            FabricaNotificacao::create('rank', ['ok' => false,
                'titulo' => 'A sicronização CDB banco Inter falhou!',
                'mensagem' => $msg,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
            throw new UserException($msg);
        }
    }

    function after($antes, $inthat) {
        if (!is_bool(strpos($inthat, $antes)))
            return substr($inthat, strpos($inthat, $antes) + strlen($antes));
    }

    function before($antes, $inthat) {
        return substr($inthat, 0, strpos($inthat, $antes));
    }

    function between($antes, $that, $inthat) {
        return $this->before($that, $this->after($antes, $inthat));
    }

}
