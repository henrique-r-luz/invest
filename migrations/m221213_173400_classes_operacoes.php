<?php

namespace app\migrations;

use yii\db\Migration;
use yii\db\Schema;

/**
 * type 1 são os pápeis 
 * type 2 são as regras
 * 
 */
class m221213_173400_classes_operacoes extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(
            'classes_operacoes',
            [
                'id' => Schema::TYPE_PK,
                'nome' => Schema::TYPE_STRING . ' NOT NULL '

            ]
        );
        $this->addColumn('ativo', 'classe_atualiza_id', Schema::TYPE_INTEGER);
        $this->addForeignKey(
            'classe_atualiza_id_fk',
            'ativo',
            'classe_atualiza_id',
            'classes_operacoes',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ativo', 'classe_atualiza_id');
        $this->dropTable('classes_operacoes');
    }
}
