<?php

namespace app\models\ir\operacoesVendas;

use yii\db\Expression;
use app\lib\dicionario\Pais;
use app\lib\dicionario\Tipo;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use app\lib\dicionario\Categoria;
use app\models\financas\Operacao;
use app\models\ir\bensDireitos\FormBensDireitos;

class VendaOperacoesSearch  extends Operacao
{

    public $resultado;
    public $tipo_ativo;
    public $pais;
    public $valor_venda;
    public $valor_compra;
    public $ativo_codigo;

    private FormBensDireitos $formBensDireito;

    public function search(FormBensDireitos $formBensDireito)
    {
        $this->formBensDireito = $formBensDireito;
        if (empty($this->formBensDireito->ano)) {
            return [];
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $this->query(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $dataProvider;
    }

    private function query()
    {


        $query = self::find()
            ->select([
                'ativo.codigo as ativo_codigo',
                'operacao.quantidade',
                'operacao.preco_medio',
                'operacao.valor as valor_venda',
                '(operacao.quantidade * operacao.preco_medio) as valor_compra',
                '(operacao.valor - (operacao.quantidade * operacao.preco_medio)) as resultado',
                'ativo.tipo as tipo_ativo',
                'ativo.pais',
                'operacao.data'
            ])
            ->innerJoinWith(['itensAtivo.ativos'])
            ->where(['investidor_id' => $this->formBensDireito->investidor_id])
            ->andWhere(new Expression(" EXTRACT(YEAR FROM  operacao.data) ='" . $this->formBensDireito->ano . "'"))
            ->andWhere(['ativo.pais' => Pais::BR])
            ->andWhere(['categoria' => Categoria::RENDA_VARIAVEL])
            ->andWhere(['operacao.tipo' => Operacao::tipoOperacaoId()[Operacao::VENDA]])
            // ->andWhere(['itens_ativo.ativo' => true])
            ->orderBy([
                'operacao.data' => \SORT_ASC,
                'ativo.codigo' => \SORT_ASC,

            ]);

        return $query;
    }
    /**
     * resume os valores de renda variável por mês
     */
    public function resumoDados()
    {

        $fii = [];
        $acoes = [];
        $operacoes = $this->query()->all();
        foreach ($operacoes as $operacao) {
            if ($operacao->tipo_ativo == Tipo::FIIS) {
                $fii[] = $operacao;
            }
            if ($operacao->tipo_ativo == Tipo::ACOES) {
                $acoes[] = $operacao;
            }
        }
        return [
            $this->resumoOperacoes($acoes), $this->resumoOperacoes($fii)
        ];
    }




    private function resumoOperacoes($acoes)
    {
        $dados = [];
        foreach ($acoes as $acao) {
            $date = date_create($acao->data);
            $dataKey = date_format($date, 'm/Y');
            if (isset($dados[$dataKey . $acao->pais])) {
                $dados[$dataKey . $acao->pais] =  [
                    'valor_compra' => $dados[$dataKey . $acao->pais]['valor_compra'] + round($acao->valor_compra ?? 0, 2),
                    'valor_venda' => $dados[$dataKey . $acao->pais]['valor_venda'] + round($acao->valor_venda ?? 0, 2),
                    'resultado' => $dados[$dataKey . $acao->pais]['resultado'] + round($acao->resultado ?? 0, 2),
                    'pais' => $acao->pais,
                    'data' => $dataKey,
                ];
            } else {
                $dados[$dataKey . $acao->pais] =  [
                    'valor_compra' => round($acao->valor_compra ?? 0, 2),
                    'valor_venda' =>  round($acao->valor_venda ?? 0, 2),
                    'resultado' =>  round($acao->resultado ?? 0, 2),
                    'pais' =>  $acao->pais,
                    'data' =>  $dataKey,
                ];
            }
        }
        ksort($dados);

        return new ArrayDataProvider([
            'allModels' =>   $dados,
            'pagination' => [
                'pageSize' => 12,
            ],
        ]);
    }
}
