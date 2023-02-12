<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use app\models\financas\ItensAtivo;
use yii\db\Query;
use yii\db\Expression;
use app\models\financas\Operacao;


class DadosRecalculaAtivos
{


    public function getDados()
    {
        calculaAtivo()
        // return $this->query()->asArray()->all();
    }

    private function calculaAtivo()
    {
        $itensAtivos = ItensAtivo::find()
            ->where(['ativo' => true])
            ->all();

        foreach ($itensAtivos as $itensAtivo) {
            list($valor_compra, $quantidade) =  $this->calculaOperacoes($itensAtivo->id);
            $itensAtivo->$quantidade = $quantidade;
            $itensAtivo->$valor_compra = $valor_compra;
            $itensAtivo->save();
        }
    }

    private function calculaOperacoes($itensAtivo_id)
    {
        $operacoes = Operacao::find()->where(['itens_ativos_id' => $itensAtivo_id])->all();
        $quantidade = 0;
        $valor_compra = 0;
        foreach ($operacoes as $operacao) {
            if (Operacao::tipoOperacao()[$operacao->tipo] == Operacao::COMPRA) {
                $quantidade += $operacao->quantidade;
                $valor_compra += $operacao->valor;
            }
            if (Operacao::tipoOperacao()[$operacao->tipo] == Operacao::DESDOBRAMENTO_MAIS) {
                $quantidade += $operacao->quantidade;
            }
            if (Operacao::tipoOperacao()[$operacao->tipo] == Operacao::DESDOBRAMENTO_MENOS) {
                $quantidade -= $operacao->quantidade;
            }
            if (Operacao::tipoOperacao()[$operacao->tipo] == Operacao::VENDA) {
                $divisor = 1;
                if ($quantidade != 0) {
                    $divisor = $quantidade;
                }
                $precoMedio = ($valor_compra / $divisor);
                $quantidade -= $operacao->quantidade;
                $valor_compra -= $operacao->quantidade * $precoMedio;
            }
        }
        return [$valor_compra, $quantidade];
    }
}
