<?php

namespace app\lib\config;

use app\lib\dicionario\Tipo;
use app\lib\helpers\InvestException;
use app\models\sincronizar\Preco;
use Yii;
use yii\db\Expression;

class ValorDollar
{

    public static function getCotacaoDollar()
    {
        $session = Yii::$app->session;
        if ($session->has('dollar')) {
            return $session->get('dollar');
        }
        $preco = self::precoDollar();
        if (empty($preco)) {
            throw new InvestException('O preço do dollar não foi inserido.');
        }
        $session->set('dollar', $preco->valor);
        return $session->get('dollar');
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
}
