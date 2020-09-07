<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m200907_143227_cotacao extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        // cria código unique para tivo
        $this->execute("CREATE UNIQUE INDEX ativo_codigo ON  ativo (codigo);");
        
         $this->execute(
                "CREATE TABLE cotacao_ativo (
                    id SERIAL PRIMARY KEY,
                    ativo_id INTEGER REFERENCES ativo(id),
                    valor real,
                    nome text
                    
                );
        ");
       
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown() {
         $this->execute("DROP INDEX ativo_data_operacao;");
         $this->execute("Drop table cotacao_ativo");
       //return true;
    }

}
