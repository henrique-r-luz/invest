<?php

namespace app\lib\config;

use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use app\models\sincronizar\Preco;
use Throwable;
use Yii;
use yii\db\Expression;

class ValorDollar
{
    public const  key  = 'dollar';

    public static function convertValorMonetario($valor, $pais)
    {
        if ($pais == Pais::US) {
            return ($valor * self::getCotacaoDollar());
        }
        return $valor;
    }

    public static function valorEmDolarView($valor, $pais)
    {
        if ($pais == Pais::US) {
            return (string)(Yii::$app->formatter->asCurrency(round($valor * self::getCotacaoDollar(), 4)))
                . '($' . Yii::$app->formatter->asCurrency(round($valor, 4)) . ')';
        }
        return $valor;
    }

    public static function getCotacaoDollar()
    {

        $cache = Yii::$app->cache;
        if ($cache->get(self::key) === false) {

            $preco = self::precoDollar();
            if ($preco != null) {
                $cache->set(self::key, $preco->valor);
            } else {
                $cache->set(self::key, 0);
            }
        }
        return $cache->get(self::key);
    }


    private static function precoDollar()
    {
        return Preco::find()
            ->select([
                new Expression("distinct on(ativo.id)  ativo.id as ativo_id"),
                'valor'
            ])
            ->innerJoinWith(['ativo'])
            ->where(['ativo.tipo' => Tipo::DOLLAR])
            ->orderBy([
                'ativo.id' => \SORT_DESC,
                'data' => \SORT_DESC
            ])->one();
    }

    public static function getDollar()
    {
        $cache = Yii::$app->cache;
        if ($cache->get(self::key) === false) {
            return 0;
        }
        $formatter = Yii::$app->formatter;
        return $formatter->asDecimal(round($cache->get(self::key), 2));
    }
}
