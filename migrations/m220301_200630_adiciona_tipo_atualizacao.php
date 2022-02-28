<?php

namespace app\migrations;

use yii\db\Migration;
use yii\db\Schema;

/**
 * 
 */
class m220301_200630_adiciona_tipo_atualizacao extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
       
        $this->execute("CREATE table sicroniza_ativo(
            id SERIAL PRIMARY KEY,
            tipo text not null  
        );");

        $this->addColumn('itens_ativo','sicroniza_ativo_id',Schema::TYPE_INTEGER);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('itens_ativo','sicroniza_ativo_id');
        $this->dropTable('sicorniza_ativo');
    }
}
