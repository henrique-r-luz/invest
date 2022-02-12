<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * 
 */
class m220212_113330_altera_tipo_dados_ativo extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       $this->alterColumn('itens_ativo','valor_compra','numeric');
       $this->alterColumn('itens_ativo','valor_liquido','numeric');
       $this->alterColumn('itens_ativo','valor_bruto','numeric');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('itens_ativo','valor_compra','real');
        $this->alterColumn('itens_ativo','valor_liquido','real');
        $this->alterColumn('itens_ativo','valor_bruto','real'); 
    }
}
