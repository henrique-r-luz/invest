<?php

namespace app\models\financas\service\operacoesAtivos;

use yii\db\Query;
use app\models\financas\Operacao;
use yii\db\Expression;

/**
 * Define a quantidade de ações e o valor delas
 *
 * @author henrique.luz <henrique_r_luz@yahoo.com.br>
 */
class DadosOperacoesAtivos
{

    private $itens_ativos_id;


    public function geraQuery()
    {

        return (new Query())
            ->select([
                $this->quantidadeAcoes() . ' as quantidade ',
                '(' . $this->valorMedioAcoes() . ')*(' . $this->quantidadeAcoes() . ') as valor_compra '
            ])
            ->from([
                'quantidade_venda' => $this->qunatidadeVendaAtivo(),
                'quantidade_compra' => $this->quantidadeCompraAtivo(),
                'desdobramento_menos' => $this->quantidadeDesdobramentoMenos(),
                'desdobramento_mais' => $this->quantidadeDesdobramentoMais(),
            ])->all();
    }


    private function qunatidadeVendaAtivo()
    {
       
        return  Operacao::find()
            ->select(['sum(quantidade) as quantidade_venda', 'sum(valor) as valor_venda'])
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' =>  Operacao::getTipoOperacaoId(Operacao::VENDA)]);
    }


    private function quantidadeCompraAtivo()
    {
        return Operacao::find()
            ->select(['sum(quantidade) as quantidade_compra', 'sum(valor) as valor_compra'])
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' =>  Operacao::getTipoOperacaoId(Operacao::COMPRA)]);
    }


    /**
     * operação que reduz a quantidade de ações da carteira
     * ex: quando uma 2 ações se trasforam em 1
     * @return [type]
     */
    private function quantidadeDesdobramentoMenos()
    {
        return Operacao::find()
            ->select(['sum(quantidade) as quantidade_desdobramento_menos'])
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' =>  Operacao::getTipoOperacaoId(Operacao::DESDOBRAMENTO_MENOS)]);
    }

    /**
     * operação que aumenta a quantidade de ações da carteira
     * ex: quando uma 1 ações se trasforam em 2
     * @return void
     * @author henrique.luz <henrique_r_luz@yahoo.com.br>
     */
    private function quantidadeDesdobramentoMais()
    {
        return Operacao::find()
            ->select(['sum(quantidade) as quantidade_desdobramento_mais'])
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' => Operacao::getTipoOperacaoId(Operacao::DESDOBRAMENTO_MAIS)]);
    }

    private function quantidadeAcoes()
    {
        return '(coalesce(quantidade_compra,0)  '
            . '- coalesce(quantidade_venda,0) '
            . '- coalesce(quantidade_desdobramento_menos,0)'
            . '+ coalesce(quantidade_desdobramento_mais,0)'
            . ')';
    }

    private function valorMedioAcoes()
    {
        return 'coalesce((valor_compra/(quantidade_compra '
            . '- coalesce(quantidade_desdobramento_menos,0)'
            . '+ coalesce(quantidade_desdobramento_mais,0)'
            . ')),0)';
    }

    /**
     * Get the value of itens_ativos_id
     */
    public function getItens_ativos_id()
    {
        return $this->itens_ativos_id;
    }

    /**
     * Set the value of itens_ativos_id
     *
     * @return  self
     */
    public function setItens_ativos_id($itens_ativos_id)
    {
        $this->itens_ativos_id = $itens_ativos_id;

        return $this;
    }
}
