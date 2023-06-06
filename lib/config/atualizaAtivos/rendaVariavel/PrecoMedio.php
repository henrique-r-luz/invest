<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use yii\db\Query;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;

class PrecoMedio
{
    private ItensAtivo $itensAtivo;
    private Operacao $operacao;

    public function __construct($itensAtivo, $operacao)
    {
        $this->itensAtivo = $itensAtivo;
        $this->operacao = $operacao;
    }

    public function getPrecoMedio()
    {
        if ($this->itensAtivo->quantidade != 0) {
            $dadosCompra  = $this->dadosCompra();
            $valor =  $dadosCompra['valor'];
            $quantidade =  $dadosCompra['quantidade'];
            return $valor / $quantidade;
        }
        return 0;
    }

    private function dadosCompra()
    {
        return (new Query())
            ->select([
                'valor',
                '(coalesce(quantidade_compra.quantidade,0) + coalesce(desdobramento_mais.quantidade,0) - coalesce(desdobramento_menos.quantidade,0)) as quantidade'
            ])
            ->from(['quantidade_compra' => $this->quantidadeCompra()])
            ->leftJoin(['desdobramento_mais' => $this->desdobramentoMais()], 'desdobramento_mais.itens_ativos_id = quantidade_compra.itens_ativos_id')
            ->leftJoin(['desdobramento_menos' => $this->desdobramentoMenos()], 'desdobramento_menos.itens_ativos_id = quantidade_compra.itens_ativos_id')
            ->one();
    }

    public function quantidadeCompra()
    {
        return Operacao::find()
            ->select([
                'itens_ativos_id',
                'sum(valor) as valor',
                'sum(quantidade) as quantidade'
            ])
            ->where(['itens_ativos_id' => $this->itensAtivo->id])
            ->andWhere(['tipo' => Operacao::tipoOperacaoId()[Operacao::COMPRA]])
            ->andWhere(['<=', 'data', $this->operacao->data])
            ->andFilterWhere(['<>', 'id', $this->operacao->id])
            ->groupBy(['itens_ativos_id']);
    }

    private function desdobramentoMais()
    {
        return Operacao::find()
            ->select([
                'itens_ativos_id',
                'sum(quantidade) as quantidade'
            ])
            ->where(['itens_ativos_id' => $this->itensAtivo->id])
            ->andWhere(['tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MAIS]])
            ->andWhere(['<=', 'data', $this->operacao->data])
            ->andFilterWhere(['<>', 'id', $this->operacao->id])
            ->groupBy(['itens_ativos_id']);
    }
    private function desdobramentoMenos()
    {
        return Operacao::find()
            ->select([
                'itens_ativos_id',
                'sum(quantidade) as quantidade'
            ])
            ->where(['itens_ativos_id' => $this->itensAtivo->id])
            ->andWhere(['tipo' => Operacao::tipoOperacaoId()[Operacao::DESDOBRAMENTO_MENOS]])
            ->andWhere(['<=', 'data', $this->operacao->data])
            ->andFilterWhere(['<>', 'id', $this->operacao->id])
            ->groupBy(['itens_ativos_id']);
    }
}
