<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\lib\helpers\InvestException;

class DeleteOperacao
{

    public static function delete(Operacao $operacao)
    {
        if (!$operacao->delete()) {
            $erro = CajuiHelper::processaErros($operacao->getErrors());
            throw new InvestException('O sistema não pode remover a operação:' . $erro . '. ');
        }
    }
}
