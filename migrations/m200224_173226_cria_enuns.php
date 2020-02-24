<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m200224_173226_cria_enuns extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {


       $this->execute("CREATE TYPE categoria_enum AS ENUM('Renda Fixa','Renda Variável');");
        
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {

        $this->execute("DROP TYPE categoria_enum;");
        return true;
    }

}
