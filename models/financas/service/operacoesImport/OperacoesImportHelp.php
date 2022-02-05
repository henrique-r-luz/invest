<?php

namespace app\models\financas\service\operacoesImport;

use Yii;
use app\models\financas\Operacao;
use app\models\financas\service\OperacaoService;

class OperacoesImportHelp{
    
    public static function delete($operacoesImport){
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $operacoes =  json_decode($operacoesImport->lista_operacoes_criadas_json,true);
            if(!isset($operacoes['operacoes_id'])){
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
}