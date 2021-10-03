<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m191210_173226_uniqui_data_ativo_compras_clear extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {



         $this->execute("CREATE UNIQUE INDEX ativo_data_operacao ON  operacao (ativo_id,data);");
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->execute("DROP INDEX ativo_data_operacao;");
        return true;
    }

}
