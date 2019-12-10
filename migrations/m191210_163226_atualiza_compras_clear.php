<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m191210_163226_atualiza_compras_clear extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {



        $this->execute("ALTER TABLE operacao ADD COLUMN create_time_holder TIMESTAMP without time zone NULL;");
        $this->execute("UPDATE operacao SET create_time_holder = data::TIMESTAMP;");
        $this->execute("ALTER TABLE operacao ALTER COLUMN data TYPE TIMESTAMP without time zone USING create_time_holder;");
        $this->execute("ALTER TABLE operacao DROP COLUMN create_time_holder;");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        //$this->execute("DROP table balanco_empresa_bolsa CASCADE;");
        return true;
    }

}
