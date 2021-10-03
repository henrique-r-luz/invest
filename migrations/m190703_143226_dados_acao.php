<?php



namespace app\migrations;


use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m190703_143226_dados_acao extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
         $this->execute(
                "CREATE TABLE acao_bolsa (
                    id SERIAL PRIMARY KEY,
                    nome TEXT NOT NULL,
                    codigo text not null,
                    setor text not null,
                    cnpj text not null
                );
        ");
          $this->execute("CREATE UNIQUE INDEX unique_cnpj ON acao_bolsa (cnpj);");
         
          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->execute("DROP table acao_bolsa CASCADE;");
        return true;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m190609_143226_inicio cannot be reverted.\n";

      return false;
      }
     */
}
