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
        $this->execute("CREATE table public.user (
            id SERIAL PRIMARY KEY,
            username varchar(50)  NOT NULL,
            password text  NOT NULL,
            authkey text
        );");

        $this->execute("CREATE UNIQUE INDEX unique_user ON  public.user(username);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('public.user');
    }
}
