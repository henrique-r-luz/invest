<?php

namespace app\migrations;

use yii\db\Migration;
use yii\db\Schema;

/**
 * 
 */
class m220306_200630_ativos_atualizar_import extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE table itens_ativo_import(
            id SERIAL PRIMARY KEY,
            operacoes_import_id INTEGER REFERENCES operacoes_import(id) NOT NULL,
            itens_ativo_id INTEGER REFERENCES itens_ativo(id) NOT NULL
        );");

        $this->execute("CREATE UNIQUE INDEX unique_operacoes_ativo_import ON  itens_ativo_import(operacoes_import_id, itens_ativo_id);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('itens_ativo_import');
    }
}
