<?php
namespace app\models\financas\service\operacoesAtivos;
use yii\db\Query;
use app\models\financas\Operacao;

class DadosAtivosBancoInter
{
    private $itens_ativos_id;

    public function geraQuery()
    {
        return (new Query())
            ->select(['(coalesce(valor_compra,0)  - coalesce(valor_venda,0)) as valor_compra'])
            ->from([
                'quantidade_venda' => $this->valorVenda(),
                'quantidade_compra' => $this->valorCompra(),
            ])->all();
    }

    private function valorVenda(){
        return Operacao::find()
            ->select('sum(valor) as valor_venda')
            ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
            ->andWhere(['tipo' => Operacao::getTipoOperacaoId(Operacao::VENDA)]);
    }


    private function valorCompra(){
        return  Operacao::find()
        ->select('sum(valor) as valor_compra')
        ->andWhere(['itens_ativos_id' => $this->itens_ativos_id])
        ->andWhere(['tipo' => Operacao::getTipoOperacaoId(Operacao::COMPRA)]);
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
