<?php

namespace app\lib\config\atualizaAtivos\rendaVariavel;

use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\financas\PrecoMedioVenda;
use app\lib\config\atualizaAtivos\AtivosOperacoesInterface;
use yii\db\Query;

class Venda implements AtivosOperacoesInterface
{
    private ItensAtivo $itensAtivo;
    private Operacao $operacao;

    public function __construct($itensAtivo, $operacao)
    {
        $this->itensAtivo = $itensAtivo;
        $this->operacao = $operacao;
    }

    public function insere()
    {
        $precoMedio = $this->getPrecoMedio();
        $precoMedio = $this->salvaPrecoMedio($precoMedio);
        $this->itensAtivo->valor_compra -=  $precoMedio * $this->operacao->quantidade;
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

            $valor =  $this->dadosCompra()['valor'];
            $quantidade =  $this->dadosCompra()['quantidade'];
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
            ->groupBy(['itens_ativos_id']);
    }

    private function salvaPrecoMedio($precoMedioValor)
    {
        $precoMedio = PrecoMedioVenda::find()->where(['operacoes_id' => $this->operacao->id])->one();
        $valorVenda = $precoMedioValor;
        if (empty($precoMedio)) {
            $precoMedio = new PrecoMedioVenda();
            $precoMedio->valor = $valorVenda;
            $precoMedio->operacoes_id = $this->operacao->id;
        } else {
            $precoMedio->valor = $valorVenda;
        }
        if (!$precoMedio->save()) {
            $erro  = CajuiHelper::processaErros($precoMedio->getErrors());
            throw new InvestException($erro);
        }
        return $valorVenda;
    }

    public function delete()
    {
        $precoMedio = $this->removePrecoMedioVenda();
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
        DeleteOperacao::delete($this->operacao);
    }

    private function removePrecoMedioVenda()
    {
        $valorPrecoMedio = 0;
        $precoMedioVenda = PrecoMedioVenda::find()->where(['operacoes_id' => $this->operacao->id])->one();
        if (empty($precoMedioVenda)) {
            return $valorPrecoMedio;
        }
        $valorPrecoMedio = $precoMedioVenda->valor;
        if (!$precoMedioVenda->delete()) {
            throw new InvestException('O preço médio não pode ser removido.');
        }
        return $valorPrecoMedio;
    }

    public function update($oldOperacao)
    {
        if (empty($oldOperacao) || $oldOperacao == null) {
            throw new InvestException('O oldOperacao não foi definido pelo sistema. ');
        }
        $precoMedioVenda = PrecoMedioVenda::find()->where(['operacoes_id' => $this->operacao->id])->one();
        $precoMedio  = $precoMedioVenda->valor;
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
