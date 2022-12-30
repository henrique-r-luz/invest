<?php

namespace app\lib\config\atualizaAtivos;

use app\lib\helpers\InvestException;
use app\models\financas\Operacao;

class AtualizaAtivoOperacaoFactory
{
    public static function getObjeto(Operacao $model)
    {

        $class =  $model->itensAtivo->ativos->classesOperacoes->nome;
        if ($class == null) {
            throw new InvestException('Classe de atualização de operação não cadastrada.');
        }
        return new $class($model);
    }
}
