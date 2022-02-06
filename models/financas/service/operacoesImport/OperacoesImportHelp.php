<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\lib\CajuiHelper;
use yii\base\UserException;
use app\models\financas\Ativo;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\models\financas\service\OperacaoService;

class OperacoesImportHelp
{

    public static function delete($operacoesImport)
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $operacoes =  json_decode($operacoesImport->lista_operacoes_criadas_json, true);
            if (!isset($operacoes['operacoes_id'])) {
                $operacoesImport->deleteUpload();
                $transaction->commit();
                return true;
            }
            foreach ($operacoes['operacoes_id'] as $operacao) {
                $objOperacao = Operacao::findOne($operacao);
                if (!empty($objOperacao)) {
                    $operacaoService = new OperacaoService($objOperacao);
                    $operacaoService->acaoDeletaOperacao();
                }
            }
            $operacoesImport->deleteUpload();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw new \Exception("Error ao remover operação Import. ");
        }
    }


    /**
     * @param 
     *  $param = [
     *              'codigo'=>codigo do ativo,
     *               'investido'=> investidor do ativo 
     *           ]
     * 
     * @return [type]
     */
    public static function getIntemAtivo($param)
    {
        return ItensAtivo::find()
            ->joinWith(['ativos'])
            ->where(['ativo.codigo' => $param['codigo']])
            ->andWhere(['investidor_id' => $param['investidor']])
            ->one();
    }

    
    /**
     * @param mixed 
     * $param = [
     *      'itensAtivo_id'=> id do investido,
     *      'quantidade'=> quantidades de ativos comprados
     *      'data' => data da compra
     *      'valor' => valor comprado
     *      'operacao' => qual operação foi feita
     *      'operacao_tipo'=> tipo de operação recuperada no arquivo csv
     * ]
     * 
     * @return [type]
     */
    public static function insereOperacao($param){
        $operacao = new Operacao();
        $operacao->itens_ativos_id = $param['itensAtivo_id'];
        $operacao->quantidade = $param['quantidade'];
        $operacao->data = $param['data'];
        $operacao->valor = $param['valor'] ;
        if (trim(strtolower($param['operacao'])) == 'venda') {
            $operacao->tipo = 0;
        } else {
            $operacao->tipo = 1;
        }
        $operacaoService = new OperacaoService($operacao);
        return $operacaoService;
    }



    /**
     * @param mixed 
     * $param = [
     *      'cdbBancoInterId' => codigo do ativo cdb Inter
     *      'valorCdbBruto' => valor bruto
     *      'valorCdbLiquido' => valor liquido
     *      'ativos' => ativo que está sendo trabalhado
     * ]
     * 
     * @return [type]
     */
    public static function AtualizaInter($param){
        $cdbBancoInter = ItensAtivo::findOne($param['cdbBancoInterId']);
        $cdbBancoInter->valor_bruto = $param['valorCdbBruto'];
        $cdbBancoInter->valor_liquido = $param['valorCdbLiquido'];
        $valorCompra = Ativo::valorCambio($cdbBancoInter->ativos, Operacao::valorDeCompraBancoInter($param['cdbBancoInterId']));
        $cdbBancoInter->valor_compra = $valorCompra;
        if (!$cdbBancoInter->save()) {
            $erros = CajuiHelper::processaErros($cdbBancoInter->getErrors()) . '</br>';
            $msg = 'A Atualização CDB banco Inter falhou!</br>' . $erros;
            throw new UserException($msg);
        }
    }
}
