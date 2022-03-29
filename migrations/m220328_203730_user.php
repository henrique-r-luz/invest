<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * 
 */
class m220328_203730_user extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE table usuario (
            id SERIAL PRIMARY KEY,
            nome varchar(50)  NOT NULL,
            senha varchar(50)  NOT NULL
        );");

        $this->execute("CREATE UNIQUE INDEX unique_user ON  usuario(nome);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('usuario');
    }
}
