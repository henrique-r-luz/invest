<?php

namespace app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\models\config\ClassesOperacoes;

/**
 * recálcula estoque dos ativos e preço médio 
 * das operações
 */
class RecalculaAtivos
{
    private $itensAtivo_id = null;
    private $transaction;



    public function __construct($itensAtivo_id = null)
    {
        $this->itensAtivo_id = $itensAtivo_id;
    }


    public function alteraIntesAtivo()
    {
        $this->calculaAtivo();
    }

    private function calculaAtivo()
    {
        $this->transaction = Yii::$app->db->beginTransaction();
        $itensAtivos = ItensAtivo::find()
            ->where(['ativo' => true])
            ->andFilterWhere(['id' => $this->itensAtivo_id])
            ->all();
        foreach ($itensAtivos as $itensAtivo) {
            list($valor_compra, $quantidade) =  $this->calculaOperacoes($itensAtivo);
            $itensAtivo->quantidade = $quantidade;
            $itensAtivo->valor_compra = $valor_compra;
            if (!$itensAtivo->save()) {
                $this->transaction->rollBack();
                throw new InvestException(CajuiHelper::processaErros($itensAtivo->getErros()));
            }
        }
        $this->transaction->commit();
    }

    private function calculaOperacoes($itensAtivo)
    {

        $operacoes = Operacao::find()
            ->where(['itens_ativos_id' => $itensAtivo->id])
            ->orderBy(['data' => \SORT_ASC])
            ->all();

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
                if ($itensAtivo->ativos->classesOperacoes->nome == ClassesOperacoes::CALCULA_ARITIMETICA_CDB_INTER) {
                    $quantidade -= $operacao->quantidade;
                    $valor_compra -= $operacao->valor;
                    continue;
                }


                //$precoMedio = ($valor_compra / $divisor);
                $precoMedio = $operacoes[$id - 1]->preco_medio;
                $quantidade -= $operacao->quantidade;
                $valor_compra -=  $operacao->quantidade * $operacoes[$id - 1]->preco_medio;
            }
            $operacao->preco_medio = $precoMedio;
            if ($itensAtivo->ativos->classesOperacoes->nome == ClassesOperacoes::CALCULA_ARITIMETICA_CDB_INTER) {
                $operacao->preco_medio = null;
            }
            if (!$operacao->save()) {
                throw new InvestException(CajuiHelper::processaErros($operacao->getErros()));
            }
            $ultimoPrecoMedio = $precoMedio;
        }
        $valor_compra  = $quantidade * $ultimoPrecoMedio;
        if ($valor_compra < 0) {
            $valor_compra = 0;
        }
        return [$valor_compra, $quantidade];
    }
}
