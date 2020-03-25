<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

use app\lib\CajuiHelper;
use app\lib\componentes\FabricaNotificacao;
use app\models\AcaoBolsa;
use app\models\BalancoEmpresaBolsa;
use Exception;
use Yii;
use yii\console\Controller;
use yii\db\Exception as Exception2;

/**
 * Description of Backgorud
 *
 * @author henrique
 */
class BackgroudController extends Controller {

  

    /**
     * Atualiza os fundamentos das empresas
     * @return void
     */
    public function actionAtualizaFundamento() {
        try {
            $erros = 'Erro na criação dos balanços : ';
            if (!file_exists('/vagrant/bot/fundamentos.csv')) {
                $this->criaMessagen([true, 'sucesso']);
                return;
                
            }
            // $old = ini_set('memory_limit', '8192M');
            $csv = array_map('str_getcsv', file('/vagrant/bot/fundamentos.csv'));

            foreach ($csv as $id => $linha) {
                //ajusta dados
                if ($id == 0) {
                    continue;
                }
                foreach ($linha as $k => $valor) {
                    if ($valor == 's/n') {
                        $csv[$id][$k] = null;
                    }
                    if ($valor == 'P') {
                        $csv[$id][$k] = null;
                    }
                    $csv[$id][$k] = $valor = str_replace('%', '', $csv[$id][$k]);
                    $csv[$id][$k] = $valor = str_replace('.', '', $csv[$id][$k]);
                    $csv[$id][$k] = $valor = str_replace(',', '.', $csv[$id][$k]);
                }
            }

            $newkeys = $csv[0];
            foreach ($csv as $id => $linha) {
                $csv[$id] = array_combine($newkeys, $linha); //recursive_change_key($linha, array('0' => 'cnpj', '1' => 'codigo','2'=>'nome','3'=>'setor'));
            }

            unset($csv[0]);

            foreach ($csv as $id => $linha) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $anoVar = str_replace(' ', '', $linha['Ano']);

                    List($mes, $ano) = explode("/", $anoVar);
                    $anoVar = $ano . '-' . $mes;
                    $linha['Ano'] = $anoVar;
                    $linha['trimestre'] = ($linha['trimestre'] == 'True') ? 1 : 0;
                    $linha['empresa'] = substr(trim($linha['empresa']), 0, 4);
                    $balanco = BalancoEmpresaBolsa::find()->where(['codigo' => $linha['empresa']])
                                    ->andWhere(['data' => $linha['Ano'], 'trimestre' => $linha['trimestre']])->one();
                    if ($balanco != null) {
                        $balanco = $this->constroiData($balanco, $linha);
                        //continue;
                    } else {
                        $balanco = new BalancoEmpresaBolsa();
                        $balanco = $this->constroiData($balanco, $linha);
                    }
                    if (!$balanco->save()) {
                        $transaction->rollBack();
                        $erros .= CajuiHelper::processaErros($balanco->getErrors()) . '</br>';

                        $this->criaMessagen([false, $erros]);
                        return;
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollBack();
                    $this->criaMessagen([false, $erros . $e]);
                    
                    throw $e;
                }
            }
            $this->criaMessagen([true, 'sucesso']);
            return;
        } catch (Exception2 $e) {
            $this->criaMessagen([false, 'Exceção capturada: '. $e->getMessage()]);
            return;
            //return [false, 'Exceção capturada: '. $e->getMessage()];
        }
    }
    
    private function  criaMessagen($resp){
        List($tipo,$msg) = $resp;
        if($tipo==true){
            $titulo = 'Fundamentos Atualizado!';
            $mensagem = 'Fundamentos Atualizado!';
        }else{
            $titulo = 'Fundamentos falhou!';
            $mensagem = $msg;
        }
         FabricaNotificacao::create('rank', ['ok' => $tipo,
                'titulo' =>$titulo,
                'mensagem' => $mensagem,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
       
    }
    
    
      public function constroiData($balanco, $linha) {

        $balanco->data = $linha['Ano'];
        $balanco->patrimonio_liquido = $linha['Pat. Líq.'] == 's/n' ? null : $linha['Pat. Líq.'];
        $balanco->receita_liquida = $linha['Receita Líq.'] == 's/n' ? null : $linha['Receita Líq.'];
        $balanco->ebitda = $linha['EBITDA'] == 's/n' ? null : $linha['EBITDA'];
        $balanco->ebit = null;
        $balanco->margem_ebit = null;
        $balanco->resultado_financeiro = $linha['Res. Fin.'] == 's/n' ? null : $linha['Res. Fin.'];
        $balanco->imposto = null;
        $balanco->lucro_liquido = $linha['Lucro Líq.'] == 's/n' ? null : $linha['Lucro Líq.'];

        $balanco->margem_liquida = $linha['Mrg. Líq.'] == 's/n' ? null : $linha['Mrg. Líq.'];
        $balanco->roe = $linha['ROE'] == 's/n' ? null : $linha['ROE'];
        $balanco->caixa = $linha['Caixa'] == 's/n' ? null : $linha['Caixa'];
        $balanco->divida_bruta = $linha['Dívida'];
        $balanco->divida_liquida = null;
        $balanco->divida_bruta_patrimonio = null;
        $balanco->divida_liquida_ebitda = $linha['D. L. / EBITDA'] == 's/n' ? null : $linha['D. L. / EBITDA'];
        $balanco->fco = $linha['FCO'] == 's/n' ? null : $linha['FCO'];
        $balanco->capex = $linha['CAPEX'] == 's/n' ? null : $linha['CAPEX'];
        $balanco->fcf = $linha['FCF'] == 's/n' ? null : $linha['FCF'];
        $balanco->fcl = '';
        $balanco->fcl_capex = $linha['FCL CAPEX'] == 's/n' ? null : $linha['FCL CAPEX'];
        $balanco->proventos = $linha['Prov.'] == 's/n' ? null : $linha['Prov.'];
        $balanco->payout = $linha['Payout'] == 's/n' ? null : $linha['Payout'];
        $balanco->pdd = $linha['PDD'] == 's/n' ? null : $linha['PDD'];

        $balanco->pdd_lucro_liquido = $linha['PDD/Lucro Líquido'] == 's/n' ? null : $linha['PDD/Lucro Líquido'];
        $balanco->indice_basileia = $linha['Índice de Basiléia'] == 's/n' ? null : $linha['Índice de Basiléia'];
        $balanco->codigo = substr(trim($linha['empresa']), 0, 4);
        $balanco->trimestre = $linha['trimestre'];
        // echo 
        return $balanco;
    }

    //put your code here
}
