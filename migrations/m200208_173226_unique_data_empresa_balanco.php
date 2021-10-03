<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m200208_173226_unique_data_empresa_balanco extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {


       $this->execute("CREATE UNIQUE INDEX balanco_data_empresa ON  balanco_empresa_bolsa(codigo,data);");
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->execute("DROP INDEX balanco_data_empresa;");
        return true;
    }

}
