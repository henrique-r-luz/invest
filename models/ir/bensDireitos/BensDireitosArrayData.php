<?php

namespace app\models\ir\bensDireitos;

use yii\data\ArrayDataProvider;
use app\models\financas\Operacao;

class BensDireitosArrayData
{
    private $operacoes;
    private $ano;
    public function __construct($operacoes, $ano)
    {
        $this->operacoes = $operacoes;
        $this->ano = $ano;
    }

    public function getProvider()
    {
        $ativoBensDireitos = [];
        foreach ($this->operacoes as $operacao) {
            $quantidadeAtual  = ($ativoBensDireitos[$operacao->itens_ativos_id]['quantidade'] ?? 0);
            $valorAtual = ($ativoBensDireitos[$operacao->itens_ativos_id]['valor_ano_atual'] ?? 0);
            $valorAnoAnterior = ($ativoBensDireitos[$operacao->itens_ativos_id]['valor_ano_anterior'] ?? 0);
            $ativoBensDireitos[$operacao->itens_ativos_id]['codigo'] =  $operacao->itensAtivo->ativos->codigo;
            $ativoBensDireitos[$operacao->itens_ativos_id]['quantidade'] = $this->calculaQuantidade($operacao, $quantidadeAtual);
            $ativoBensDireitos[$operacao->itens_ativos_id]['valor_ano_atual'] = $this->calculaValorCompra($operacao, $valorAtual, $quantidadeAtual);
            $ativoBensDireitos[$operacao->itens_ativos_id]['valor_ano_anterior'] = $this->calculaValorCompraAnoAnterior($operacao, $valorAnoAnterior, $quantidadeAtual);
        }
        $provider = new ArrayDataProvider([
            'allModels' =>  $ativoBensDireitos,

            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $provider;
    }

    private function calculaQuantidade($operacao, $quantidadeTotal)
    {
        $quantidadeCalculado = $quantidadeTotal;
        if (
            $operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]
            || $operacao->tipo == Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS]
        ) {
            $quantidadeCalculado -= $operacao->quantidade;
        } else {
            $quantidadeCalculado += $operacao->quantidade;
        }
        return $quantidadeCalculado;
    }

    private function calculaValorCompraAnoAnterior($operacao, $valorTotal, $quantidadeCalculado)
    {
        $anoOperacao = date('Y', strtotime($operacao->data));
        if ($anoOperacao < $this->ano) {
            $valorCalculado = $valorTotal;
            if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
                return  $this->venda($valorCalculado, $operacao, $quantidadeCalculado);
            }
            if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA]) {
                return $this->compra($valorCalculado, $operacao->valor);
            }
        }
        return $valorTotal;
    }

    private function  calculaValorCompra($operacao, $valorTotal, $quantidadeCalculado)
    {
        $valorCalculado = $valorTotal;
        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]) {
            return  $this->venda($valorCalculado, $operacao, $quantidadeCalculado);
        }
        if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA]) {
            return $this->compra($valorCalculado, $operacao->valor);
        }
        return $valorTotal;
    }


    private function compra($valorCalculado, $valorOperacao)
    {
        $calculo = $valorCalculado + $valorOperacao;
        return $calculo;
    }

    private function venda($valorCalculado, $operacao, $quantidadeCalculado)
    {
        $denominador = $quantidadeCalculado;
        if ($quantidadeCalculado == 0) {
            $denominador = 1;
        }
        $precoMedio = $valorCalculado / $denominador;
        $novoValorCompra = $valorCalculado;
        $novoValorCompra -= $precoMedio * $operacao->quantidade;
        return $novoValorCompra;
    }
}
