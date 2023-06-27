<?php

namespace app\lib\config;

use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use app\lib\helpers\InvestException;
use app\models\sincronizar\Preco;
use Yii;
use yii\db\Expression;

class ValorDollar
{

    public static function convertValorMonetario($valor, $pais)
    {
        if ($pais == Pais::US) {
            return ($valor * self::getCotacaoDollar());
        }
        return $valor;
    }

    private static function getCotacaoDollar()
    {
        $session = Yii::$app->session;
        if ($session->has('dollar') && $session->get('dollar') == 1) {
            $preco = self::precoDollar();
            return self::setPrecoDollar($session, $preco);
        }
        if ($session->has('dollar')) {
            return $session->get('dollar');
        }
        $preco = self::precoDollar();
        if (empty($preco)) {
            $session->set('dollar', 1);
            throw new InvestException('O preço do dollar não foi inserido.');
        }
        $session->set('dollar', $preco->valor);
        return $session->get('dollar');
    }


    private static function setPrecoDollar($session, $preco)
    {
        if (!empty($preco)) {
            $session->set('dollar', $preco->valor);
            return $session->get('dollar');
        }
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
        $session = Yii::$app->session;
        $formatter = Yii::$app->formatter;
        return $formatter->asCurrency(round($session->get('dollar'), 2));
    }
}
