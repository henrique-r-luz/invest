<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use yii\db\Query;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;

use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;


class Venda implements AtivosOperacoesInterface
{
    private ItensAtivo $itensAtivo;
    private Operacao $operacao;
    private $precoMedio = 0;

    public function __construct($itensAtivo, $operacao)
    {
        $this->itensAtivo = $itensAtivo;
        $this->operacao = $operacao;
        $this->precoMedio =  $this->getPrecoMedio();
    }

    public function insere()
    {
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $this->itensAtivo->valor_compra -=  $this->precoMedio * $this->operacao->quantidade;
        $this->itensAtivo->quantidade -= $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido -= $this->operacao->valor;
        $this->itensAtivo->valor_bruto -= $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    private function getPrecoMedio()
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

    private function quantidadeCompra()
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

    public function delete()
    {
        $precoMedio = $this->precoMedio;
        $operacaoAux = $this->operacao;
        DeleteOperacao::delete($operacaoAux);
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        if ($precoMedio !== 0) {
            $this->itensAtivo->valor_compra += $precoMedio * $this->operacao->quantidade;
        } else {
            $this->itensAtivo->valor_compra += $this->operacao->valor;
        }
        $this->itensAtivo->quantidade += $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido += $this->operacao->valor;
        $this->itensAtivo->valor_bruto += $this->operacao->valor;

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }

    public function update($oldOperacao)
    {
        if (empty($oldOperacao) || $oldOperacao == null) {
            throw new InvestException('O oldOperacao não foi definido pelo sistema. ');
        }
        if (CalculaItensAtivoPorData::verificaDataOperacao($this->operacao)) {
            return true;
        }
        $precoMedio  = $this->precoMedio;
        $this->itensAtivo->valor_compra =  ($this->itensAtivo->valor_compra + ($oldOperacao['quantidade'] * $precoMedio)) - ($precoMedio * $this->operacao->quantidade);
        $this->itensAtivo->quantidade = ($this->itensAtivo->quantidade + $oldOperacao['quantidade']) - $this->operacao->quantidade;
        $this->itensAtivo->valor_liquido = ($this->itensAtivo->valor_liquido + $oldOperacao['valor']) - $this->operacao->valor;
        $this->itensAtivo->valor_bruto = ($this->itensAtivo->valor_bruto + $oldOperacao['valor']) - $this->operacao->valor;  //$this->operacao->valor - $oldOperacao['valor'];

        if (!$this->itensAtivo->save()) {
            $erro  = CajuiHelper::processaErros($this->itensAtivo->getErrors());
            throw new InvestException($erro);
        }
    }
}
