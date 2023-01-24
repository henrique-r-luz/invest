<?php

namespace app\migrations;

use yii\db\Schema;
use yii\db\Migration;



class m230121_203400_atualiza_nu extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('DROP TABLE IF EXISTS public.itens_ativo_import;');
        $this->createTable(
            'atualiza_nu',
            [
                'id' => Schema::TYPE_PK,
                'valor_bruto_antigo' => ' NUMERIC NOT NULL ',
                'valor_liquido_antigo' => ' NUMERIC NOT NULL ',
                'operacoes_import_id' => ' INTEGER NOT NULL ',
                'itens_ativo_id' => ' INTEGER NOT NULL '

            ]
        );
        $this->addForeignKey(
            'atualiza_nu_operacoes_import_pk',
            'atualiza_nu',
            'operacoes_import_id',
            'operacoes_import',
            'id'
        );

        $this->addForeignKey(
            'atualiza_nu_itens_ativo_pk',
            'atualiza_nu',
            'itens_ativo_id',
            'itens_ativo',
            'id'
        );

        $this->execute("CREATE UNIQUE INDEX IF NOT EXISTS unique_operacoes_import_ativo
                        ON public.atualiza_nu(operacoes_import_id, itens_ativo_id);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('atualiza_nu');
    }
}
