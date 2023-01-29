<?php

namespace app\migrations;

use yii\db\Schema;
use yii\db\Migration;



class m230128_143400_atualiza_manual extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->execute("DROP TABLE IF EXISTS public.arvore;");
        $this->createTable(
            'atualiza_ativo_manual',
            [
                'id' => Schema::TYPE_PK,
                'itens_ativo_id' => ' INTEGER NOT NULL '

            ]
        );
        $this->addForeignKey(
            'atualiza_ativo_manual_itens_ativo_id_fk',
            'atualiza_ativo_manual',
            'itens_ativo_id',
            'itens_ativo',
            'id'
        );

        $this->execute("CREATE UNIQUE INDEX IF NOT EXISTS unique_atualiza_ativo_manual
                        ON public.atualiza_ativo_manual(itens_ativo_id);");

        $this->createTable(
            'atualiza_operacoes_manual',
            [
                'id' => Schema::TYPE_PK,
                'valor_bruto' => ' NUMERIC NOT NULL ',
                'valor_liquido' => ' NUMERIC NOT NULL ',
                'atualiza_ativo_manual_id' => ' INTEGER NOT NULL ',
                'data' => ' timestamp without time zone NOT NULL ',
            ]
        );

        $this->addForeignKey(
            'atualiza_operacoes_manual_atualiza_ativo_manual_id_fk',
            'atualiza_operacoes_manual',
            'atualiza_ativo_manual_id',
            'atualiza_ativo_manual',
            'id'
        );
        $this->execute("CREATE UNIQUE INDEX IF NOT EXISTS unique_atualiza_operacoes_manual
                        ON public.atualiza_operacoes_manual(atualiza_ativo_manual_id, data);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('atualiza_operacoes_manual');
        $this->dropTable('atualiza_ativo_manual');
    }
}
