<?php

namespace app\lib\config\atualizaAtivos\rendaFixa\cdbInter;

use Yii;
use app\lib\CajuiHelper;
use app\models\financas\Operacao;
use app\models\financas\ItensAtivo;
use app\lib\helpers\InvestException;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\lib\config\atualizaAtivos\AtualizaAtivoInterface;
use app\lib\config\atualizaAtivos\ValorBrutoLiquidoFactory;


class CalculaAritimeticaCDBInter implements AtualizaAtivoInterface
{
    private Operacao $operacao;

    private $transaction;

    private int $itensAtivo_id;

    public $oldOperacao = [];

    public string $tipoOperacao;


    public function __construct(Operacao $operacao)
    {
        $this->operacao = $operacao;
        $this->itensAtivo_id =  $this->operacao->itens_ativos_id;
    }

    public function getOperacao()
    {
        return  $this->operacao;
    }

    public function setTipoOperacao($tipoOperacao)
    {
        $this->tipoOperacao = $tipoOperacao;
        // não  implementado;
    }


    public function setOldOperacao($oldOperacao)
    {
        $this->oldOperacao = $oldOperacao;
    }



    public function atualiza()
    {
        if ($this->tipoOperacao === TiposOperacoes::DELETE) {
            if (!$this->operacao->delete()) {
                throw new InvestException('Erro ao deletar operação');
            }
        }
        $this->calculaAtivo();
    }
    private function calculaAtivo()
    {
        $this->transaction = Yii::$app->db->beginTransaction();
        $itensAtivo = ItensAtivo::find()
            ->where(['ativo' => true])
            ->andWhere(['itens_ativo.id' => $this->itensAtivo_id])
            ->one();
        if (empty($itensAtivo)) {
            throw new InvestException('O item Ativo da operação não foi encontrato.');
        }
        list($valor_compra, $quantidade) =  $this->calculaOperacoes($itensAtivo);
        $itensAtivo->quantidade = $quantidade;
        $itensAtivo->valor_compra = $valor_compra;
        $itensAtivo = ValorBrutoLiquidoFactory::getObjeto($this, $itensAtivo)->calcula();
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
                $quantidade -= $operacao->quantidade;
                $valor_compra -=  $operacao->valor;
            }
        }
        if ($valor_compra < 0) {
            $valor_compra = 0;
        }
        return [$valor_compra, $quantidade];
    }
}
