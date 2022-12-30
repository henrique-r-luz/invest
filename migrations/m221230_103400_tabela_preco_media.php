<?php

namespace app\migrations;

use yii\db\Schema;
use yii\db\Migration;


class m221230_103400_tabela_preco_media extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'preco_medio_venda',
            [
                'valor' => ' NUMERIC NOT NULL ',
                'operacoes_id' => Schema::TYPE_INTEGER . ' NOT NULL '

            ]
        );
        $this->addForeignKey(
            'operacao_preco_media_id_fk',
            'preco_medio_venda',
            'operacoes_id',
            'operacao',
            'id'
        );

        $this->execute("CREATE UNIQUE INDEX IF NOT EXISTS preco_medio_venda_unique_operacao
        ON public.preco_medio_venda USING btree
        (operacoes_id ASC NULLS LAST)
        TABLESPACE pg_default;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP INDEX IF EXISTS public.preco_medio_venda_unique_operacao;");
        $this->dropTable('preco_medio_venda');
    }
}
