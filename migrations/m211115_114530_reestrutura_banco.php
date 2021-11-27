<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;
use app\models\financas\Operacao;
use app\models\financas\Proventos;
use app\models\financas\ItensAtivo;

/**
 * Class m190609_143226_inicio
 */
class m211115_114530_reestrutura_banco extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
        // INSERE VALORES EM ITENS_ATIVOS      
        foreach (Ativo::find()->each(10) as $ativo) {
            $this->insert('itens_ativo', [
                'ativo_id' => $ativo->id,
                'valor_compra'=>$ativo->valor_compra, 'investidor_id' => $ativo->investidor_id,
                'quantidade' => $ativo->quantidade, 'valor_liquido' => $ativo->valor_liquido,
                'valor_bruto' => $ativo->valor_bruto, 'ativo' => $ativo->ativo
            ]);
        }
        //insere valores em operações
        $this->addColumn('operacao','itens_ativos_id','integer');
        foreach (Operacao::find()->each(10) as $operacao) {
            $operacao->itens_ativos_id = ItensAtivo::find()->where(['ativo_id'=>$operacao->ativo_id])->one()->id;
            $operacao->save(false);
        }
        //insere Proventos
        $this->addColumn('proventos','itens_ativos_id','integer');
        foreach (Proventos::find()->each(10) as $proventos) {
            $proventos->itens_ativos_id = ItensAtivo::find()->where(['ativo_id'=>$proventos->ativo_id])->one()->id;
            $proventos->save(false);
        }

        //remove colunas intes_ativos
        $this->dropColumn('ativo','quantidade');
        $this->dropColumn('ativo','valor_compra');
        $this->dropColumn('ativo','valor_bruto');
        $this->dropColumn('ativo','valor_liquido');
        $this->dropColumn('ativo','investidor_id');
        $this->dropColumn('ativo','ativo');

        //remove colunas operação
        $this->dropColumn('operacao','ativo_id');
        $this->dropColumn('proventos','ativo_id');
        
        //$this->execute("CREATE UNIQUE INDEX ativo_codigo_unique ON  ativo (codigo);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
    }
}
