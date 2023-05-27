<?php

namespace app\models\ir\operacoesVendas;

use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use yii\data\ArrayDataProvider;
use app\models\financas\Operacao;

class OperacoesVendasArrayData
{
    private $operacoes;
    private $ano;
    public function __construct($operacoes, $ano)
    {
        $this->operacoes = $operacoes;
        $this->ano = $ano;
    }


    private function dados()
    {
        $todasOperacoes = [];
        $operacoesvendas = [];
        foreach ($this->operacoes as $operacao) {

            $valor_compra = ($todasOperacoes[$operacao->itens_ativos_id]['valor_compra'] ?? 0);
            $quantidade_ativo = $todasOperacoes[$operacao->itens_ativos_id]['quantidade_ativo'] ?? 0;
            $valorEstoque  = 0;
            $anoOperacao = date('Y', strtotime($operacao->data));
            $mesOperacao = date('m', strtotime($operacao->data));
            if ($operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA] && $anoOperacao == $this->ano) {
                $precoMedio = round(($this->precoMedio($valor_compra, $quantidade_ativo)), 3);
                $valorEstoque  = $precoMedio * $operacao->quantidade;
                $operacoesvendas[$operacao['id']]['codigo']  = $operacao->itensAtivo->ativos->codigo;
                $operacoesvendas[$operacao['id']]['preco_medio'] =  $precoMedio;
                $operacoesvendas[$operacao['id']]['valor_compra'] = $valorEstoque;
                $operacoesvendas[$operacao['id']]['valor_venda'] = $operacao->valor;
                $operacoesvendas[$operacao['id']]['quantidade_vendida'] = $operacao->quantidade;
                $operacoesvendas[$operacao['id']]['resultado'] = round($operacao->valor  - ($valorEstoque), 2);
                $operacoesvendas[$operacao['id']]['data'] = $mesOperacao . '/' . $anoOperacao;
                $operacoesvendas[$operacao['id']]['tipo'] = $operacao->itensAtivo->ativos->tipo;
                $operacoesvendas[$operacao['id']]['pais'] = $operacao->itensAtivo->ativos->pais;
            }

            $todasOperacoes[$operacao->itens_ativos_id]['codigo'] =  $operacao->itensAtivo->ativos->codigo;
            $todasOperacoes[$operacao->itens_ativos_id]['valor_compra'] = $this->valorCompra($valor_compra, $operacao, $valorEstoque);
            $todasOperacoes[$operacao->itens_ativos_id]['quantidade_ativo'] = $this->calculaQuantidade($operacao, $quantidade_ativo);
        }
        return  ['operacoesvendas' => $operacoesvendas];
    }

    public function getProviderDetalhado()
    {

        $operacoesvendas = $this->dados();
        $provider = new ArrayDataProvider([
            'allModels' =>   $operacoesvendas['operacoesvendas'],

            'pagination' => [
                'pageSize' => 50,
            ],
        ]);
        return $provider;
    }




    public function getProviderResumoFii()
    {
        $operacoesvendas = $this->dados()['operacoesvendas'];
        $fiis = [];
        foreach ($operacoesvendas as $operacao) {
            if ($operacao['tipo'] == Tipo::FIIS && $operacao['pais'] == Pais::BR) {
                $fiis[$operacao['data']]['resultado'] = ($fiis[$operacao['data']]['resultado'] ?? 0) + $operacao['resultado'];
                $fiis[$operacao['data']]['valor_compra'] = ($fiis[$operacao['data']]['valor_compra'] ?? 0) + $operacao['valor_compra'];
                $fiis[$operacao['data']]['valor_venda'] = ($fiis[$operacao['data']]['valor_venda'] ?? 0) + $operacao['valor_venda'];
                $fiis[$operacao['data']]['data'] = $operacao['data'];
                $fiis[$operacao['data']]['pais'] = $operacao['pais'];
            }
        }
        $provider = new ArrayDataProvider([
            'allModels' =>   $fiis,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $provider;
    }


    public function getProviderResumoAcoes()
    {
        $operacoesvendas = $this->dados()['operacoesvendas'];
        $acoes = [];
        foreach ($operacoesvendas as $operacao) {
            if ($operacao['tipo'] == Tipo::ACOES && $operacao['pais'] == Pais::BR) {
                $acoes[$operacao['data']]['resultado'] = ($acoes[$operacao['data']]['resultado'] ?? 0) + $operacao['resultado'];
                $acoes[$operacao['data']]['valor_compra'] = ($acoes[$operacao['data']]['valor_compra'] ?? 0) + $operacao['valor_compra'];
                $acoes[$operacao['data']]['valor_venda'] = ($acoes[$operacao['data']]['valor_venda'] ?? 0) + $operacao['valor_venda'];
                $acoes[$operacao['data']]['data'] = $operacao['data'];
                $acoes[$operacao['data']]['pais'] = $operacao['pais'];
            }
        }
        $provider = new ArrayDataProvider([
            'allModels' =>   $acoes,
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        return $provider;
    }


    private function calculaQuantidade($operacao, $quantidade_ativo)
    {
        $quantidadeCalculado = $quantidade_ativo;
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

    public function precoMedio($valor_compra, $quantidade_ativo)
    {
        if ($quantidade_ativo == 0) {
            return 0;
        }
        return $valor_compra / $quantidade_ativo;
    }


    private function valorCompra($valor_compra, $operacao, $valor_compra_preco_medio = 0)
    {
        $valorCalculado = $valor_compra;
        if (
            $operacao->tipo == Operacao::tipoOperacaoId()[Operacao::COMPRA]
        ) {
            $valorCalculado  += $operacao->valor;
        }
        if (
            $operacao->tipo == Operacao::tipoOperacaoId()[Operacao::VENDA]
        ) {
            $valorCalculado  -= $valor_compra_preco_medio;
        }
        return $valorCalculado;
    }
}
