<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\models\financas\Operacao;
use app\lib\config\atualizaAtivos\AtualizaValorAtual;

class CalculaItensAtivoPorData
{

    public static function verificaDataOperacao($operacao)
    {
        if (Operacao::find()
            ->where(['itens_ativos_id' => $operacao->itens_ativos_id])
            ->andWhere(['>', 'data', $operacao->data])
            ->exists()
        ) {
            AtualizaValorAtual::atualizaValorBrutoLiquido($operacao->itens_ativos_id);
            return true;
        }
        return false;
    }
}
