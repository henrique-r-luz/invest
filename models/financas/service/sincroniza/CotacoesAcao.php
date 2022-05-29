<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models\financas\service\sincroniza;

use Yii;
use yii\db\Exception;
use app\lib\CajuiHelper;
use yii\base\UserException;
use app\models\financas\Ativo;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\service\sincroniza\OperacoesAbstract;
use app\models\financas\service\sincroniza\SincronizaFactory;

/**
 * Description of CotacoesAcao
 *
 * @author henrique
 */
class CotacoesAcao extends OperacoesAbstract
{

    private $csv;
    private $erros;

    //put your code here
    public function atualiza()
    {

        foreach ($this->csv as $acoes) {
            $contErro = 0;
            $itensAtivos = ItensAtivo::find()->where(['ativo_id' => $acoes['id']])->all();
            foreach ($itensAtivos as $itensAtivo) {
                if ($acoes['valor'][2] == '.') {
                    $acoes['valor'][2] = ',';
                }
                $valor = str_replace('.', '', $acoes['valor']);
                $valor = str_replace(',', '.', $valor);
                $valor = Ativo::valorCambio($itensAtivo->ativos, $valor);
                $valor = $valor;

                $lucro = ($valor * $itensAtivo->quantidade);
                $itensAtivo->valor_bruto = $lucro;
                $itensAtivo->valor_liquido = $lucro;
                $valorCompra = Ativo::valorCambio($itensAtivo->ativos, Operacao::valorDeCompra($itensAtivo->id));
                $itensAtivo->valor_compra = $valorCompra;

                if (!$itensAtivo->save()) {
                    $this->erros .= CajuiHelper::processaErros($itensAtivo->getErrors()) . '</br>';
                    $contErro++;
                }
            }
        }
        if ($contErro != 0) {
            $msg = 'A Cotação açoes não foram atualizados !</br>' . $this->erros;
            throw new InvestException($msg);
        }
    }

    public function getDados()
    {
        $file = Yii::$app->params['bot'] . '/preco_acao.csv';
        if (!file_exists($file)) {
            return [true, 'sucesso'];
        }
        $this->csv = array_map('str_getcsv', file($file));
        $newkeys = array('id', 'valor');
        foreach ($this->csv as $id => $linha) {
            $this->csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
        }
        unset($this->csv[0]);
    }
}
