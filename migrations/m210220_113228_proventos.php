<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m210220_113228_proventos extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute(
                "CREATE TABLE proventos (
                    id SERIAL PRIMARY KEY,
                    ativo_id INTEGER REFERENCES ativo(id) NOT NULL,
                    data timestamp without time zone NOT NULL,
                    valor real NOT NULL
                );
        ");
        
        $this->execute("CREATE UNIQUE INDEX ativo_data_provento ON  proventos (ativo_id,data);");
      
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       $this->execute("DROP table proventos CASCADE;");
    }

}
