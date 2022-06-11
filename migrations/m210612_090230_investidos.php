<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;


/**
 * Class m190609_143226_inicio
 */
class m210612_090230_investidos extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute(
                "CREATE TABLE investidor (
                    id SERIAL PRIMARY KEY,
                    cpf varchar(11) NOT NULL UNIQUE,
                    nome text NOT NULL
                );
        ");
        //altera coluna ativos
        $this->execute("ALTER TABLE ativo ADD COLUMN investidor_id INTEGER;");
        $this->execute("ALTER TABLE ativo 
                        ADD CONSTRAINT fk_investido_id
                        FOREIGN KEY (investidor_id) 
                        REFERENCES investidor(id);");
        
     
      
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
     
       $this->execute("ALTER TABLE ativo DROP COLUMN investidor_id;"); 
       $this->execute("DROP table investidor CASCADE;");
    }

}
