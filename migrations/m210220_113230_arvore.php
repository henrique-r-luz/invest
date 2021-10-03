<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m210220_113230_arvore extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute(
                "CREATE TABLE arvore (
                    id SERIAL PRIMARY KEY,
                    parent INTEGER REFERENCES arvore(id),
                    nome text NOT NULL,
                    valor real NOT NULL
                );
        ");
        
       // $this->execute("CREATE UNIQUE INDEX ativo_data_provento ON  proventos (ativo_id,data);");
      
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       $this->execute("DROP table arvore CASCADE;");
    }

}
