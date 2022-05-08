<?php

namespace app\migrations;


use yii\db\Migration;

/**
 * type 1 são os pápeis 
 * type 2 são as regras
 * 
 */
class m220508_133630_altera_tipo_auth extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('ALTER TABLE public.auth_assignment ALTER COLUMN user_id TYPE integer USING (user_id::integer);');
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return true;
       
    }
}
