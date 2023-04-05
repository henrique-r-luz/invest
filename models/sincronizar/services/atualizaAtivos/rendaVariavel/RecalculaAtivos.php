<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\config\ClassesOperacoes;


class RecalculaAtivos
{


    public function __construct()
    {
    }
    public function alteraIntesAtivo()
    {
        $this->calculaAtivo();
    }

    private function calculaAtivo()
    {
        $itensAtivos = ItensAtivo::find()
            ->where(['ativo' => true])
            ->all();

        foreach ($itensAtivos as $itensAtivo) {
            list($valor_compra, $quantidade) =  $this->calculaOperacoes($itensAtivo);
            $itensAtivo->quantidade = $quantidade;
            $itensAtivo->valor_compra = $valor_compra;
            $itensAtivo->save();
        }
    }

    private function calculaOperacoes($itensAtivo)
    {
        $operacoes = Operacao::find()
            ->where(['itens_ativos_id' => $itensAtivo->id])
            ->orderBy(['data' => \SORT_ASC])
            ->all();

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
                if ($itensAtivo->ativos->classesOperacoes->nome == ClassesOperacoes::CALCULA_ARITIMETICA) {
                    $quantidade -= $operacao->quantidade;
                    $valor_compra -= $operacao->valor;
                    continue;
                }

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
