<?php

namespace app\migrations;


use yii\db\Migration;

/**
 * type 1 são os pápeis 
 * type 2 são as regras
 * 
 */
class m220409_143630_auditoria extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Criação da tabela de auditoria
        $this->createTable('auditoria', [
            'id'         => 'SERIAL PRIMARY KEY',
            'model'      => $this->text()->notNull(),
            'operacao'   => $this->text()->notNull(),
            'changes'    => 'JSONB NOT NULL',
            'user_id'    => 'INTEGER REFERENCES public.user(id) NOT NULL',
            'created_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
       $this->dropTable('auditoria');
    }
}
