<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\models\financas\Operacao;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

class CalculaItensAtivoPorData
{

    public static function verificaDataOperacao($operacao)
    {
        if (Operacao::find()
            ->where(['itens_ativos_id' => $operacao->itens_ativos_id])
            ->andWhere(['>', 'data', $operacao->data])
            ->exists()
        ) {
            $recalculaAtivos = new RecalculaAtivos($operacao->itens_ativos_id);
            $recalculaAtivos->alteraIntesAtivo();
            return true;
        }
        return false;
    }
}
