<?php

namespace app\migrations;

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
                'valor_bruto_antigo' => ' NUMERIC NOT NULL ',
                'valor_liquido_antigo' => ' NUMERIC NOT NULL ',
                'operacoes_import_id' => ' INTEGER PRIMARY KEY ',

            ]
        );
        $this->addForeignKey(
            'atualiza_nu_operacoes_import_pk',
            'atualiza_nu',
            'operacoes_import_id',
            'operacoes_import',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('atualiza_nu');
    }
}
