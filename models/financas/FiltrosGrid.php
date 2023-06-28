<?php

namespace app\models\financas;

class FiltrosGrid
{
    public static function  pesquisaAtivo($query, $input)
    {

        if ($input === null) {
            return $query;
        }
        if (preg_match('/^(?=.*\d)\d{1,}$/', $input) == 1) {
            $query->andFilterWhere(['ativo.id' => $input]);
        } else {
            $query->andFilterWhere(['ilike', 'ativo.codigo', $input]);
        }

        return $query;
    }
}
