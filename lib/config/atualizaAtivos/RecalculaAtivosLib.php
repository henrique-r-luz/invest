<?php

namespace app\lib\config\atualizaAtivos;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;

/**
 * recálcula quantidade do item ativo e preço médio 
 * das operações
 */
class RecalculaAtivosLib
{
    private $itensAtivo_id;
    private $transaction;
    private AtualizaAtivoInterface $classe;



    public function __construct($itensAtivo_id, $classe)
    {
        $this->itensAtivo_id = $itensAtivo_id;
        $this->classe = $classe;
    }


    public function alteraIntesAtivo()
    {
        $this->calculaAtivo();
    }

    private function calculaAtivo()
    {
        $this->transaction = Yii::$app->db->beginTransaction();
        $itensAtivo = ItensAtivo::find()
            ->select('itens_ativo.*, preco.valor as preco_valor ')
            ->joinWith(['ativos.precos'])
            ->where(['ativo' => true])
            ->andWhere(['itens_ativo.id' => $this->itensAtivo_id])
            ->orderBy(['preco.data' => \SORT_DESC])
            ->one();
        if (empty($itensAtivo)) {
            throw new InvestException('O item Ativo da operação não foi encontrato.');
        }
        list($valor_compra, $quantidade) =  $this->calculaOperacoes($itensAtivo);
        $itensAtivo->quantidade = $quantidade;
        $itensAtivo->valor_compra = $valor_compra;
        $itensAtivo = ValorBrutoLiquidoFactory::getObjeto($this->classe, $itensAtivo)->calcula();
        if (!$itensAtivo->save()) {
            $this->transaction->rollBack();
            throw new InvestException(CajuiHelper::processaErros($itensAtivo->getErros()));
        }

        $this->transaction->commit();
    }

    private function calculaOperacoes($itensAtivo)
    {

        $operacoes = Operacao::find()
            ->where(['itens_ativos_id' => $itensAtivo->id])
            ->orderBy(['data' => \SORT_ASC])
            ->all();
        return $this->calculaOperacaoesAtivos($operacoes);
    }


    private function  calculaOperacaoesAtivos($operacoes)
    {
        $quantidade = 0;
        $valor_compra = 0;
        $ultimoPrecoMedio = 0;

        foreach ($operacoes as $id => $operacao) {
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
            $precoMedio = round(($valor_compra / ($quantidade == 0 ? 1 : $quantidade)), 2);
            if (Operacao::tipoOperacao()[$operacao->tipo] == Operacao::VENDA) {
                $precoMedio = $operacoes[$id - 1]->preco_medio;
                $quantidade -= $operacao->quantidade;
                $valor_compra -=  $operacao->quantidade * $operacoes[$id - 1]->preco_medio;
            }
            $operacao->preco_medio = $precoMedio;
            if (!$operacao->save()) {
                throw new InvestException(CajuiHelper::processaErros($operacao->getErros()));
            }
            $ultimoPrecoMedio =  $precoMedio;
        }
        $valor_compra  = $quantidade * $ultimoPrecoMedio;

        if ($valor_compra < 0) {
            $valor_compra = 0;
        }
        return [$valor_compra, $quantidade];
    }
}
