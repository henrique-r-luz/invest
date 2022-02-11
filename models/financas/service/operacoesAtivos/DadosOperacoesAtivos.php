<?php

namespace app\models\financas\service\operacoesAtivos;

use yii\db\Query;
use app\models\financas\Operacao;
use yii\db\Expression;

class DadosOperacoesAtivos
{

    private $venda = 0;
    private $compra = 1;
    private $desdobramentoMais = 2;
    private $desdobramentoMenos = 3;
    private $itens_ativos_id;


    public function geraQuery()
    {

        return (new Query())
            ->select([$this->quantidadeAcoes().' as quantidade ',
                    '('.$this->valorMedioAcoes().')*('.$this->quantidadeAcoes().') as valor_compra '
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
        ->andWhere(['tipo' => $this->venda]);
    }


    private function quantidadeCompraAtivo()
    {
       return Operacao::find()
            ->select(['sum(quantidade) as quantidade_compra', 'sum(valor) as valor_compra'])
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' => $this->compra]);
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
            ->andWhere(['tipo' => $this->desdobramentoMenos]);
    }

    /**
     * operação que aumenta a quantidade de ações da carteira
     * ex: quando uma 1 ações se trasforam em 2
     * @return [type]
     */
    private function quantidadeDesdobramentoMais()
    {
        return Operacao::find()
            ->select(['sum(quantidade) as quantidade_desdobramento_mais'])
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' => $this->desdobramentoMais]);
    }

    private function quantidadeAcoes()
    {
        return '(coalesce(quantidade_compra,0)  '
            . '- coalesce(quantidade_venda,0) '
            . '- coalesce(quantidade_desdobramento_menos,0)'
            . '+ coalesce(quantidade_desdobramento_mais,0)'
              . ')';
    }

    private function valorMedioAcoes(){
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
