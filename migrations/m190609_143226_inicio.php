<?php



namespace app\migrations;


use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m190609_143226_inicio extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
         $this->execute(
                "CREATE TABLE tipo (
                    id SERIAL PRIMARY KEY,
                    nome TEXT NOT NULL
                );
        ");
         
           $this->execute(
                "CREATE TABLE categoria (
                    id SERIAL PRIMARY KEY,
                    nome TEXT NOT NULL
                );
        ");
        
        $this->execute(
                "CREATE TABLE ativo (
                    id SERIAL PRIMARY KEY,
                    nome TEXT NOT NULL,
                    codigo text not null,
                    quantidade real,
                    valor_compra real,
                    valor_bruto real,
                    valor_liquido real,
                    tipo_id INTEGER REFERENCES tipo(id) NOT NULL,
                    categoria_id INTEGER REFERENCES categoria(id) NOT NULL
                );
        ");
        
          $this->execute(
                "CREATE TABLE operacao (
                    id SERIAL PRIMARY KEY,
                    tipo TEXT integer NULL,--compra ou venda
                    quantidade integer not null,
                    valor real not null,
                    data date not null,
                    ativo_id INTEGER REFERENCES ativo(id) NOT NULL
                );
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->execute("DROP table operacao CASCADE;");
        $this->execute("DROP table atipo CASCADE;");
        $this->execute("DROP table tipo CASCADE;");
        $this->execute("DROP table categoria CASCADE;");
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
