<?php



namespace app\migrations;


use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m190818_143226_campo_ativo extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
         $this->execute(
                "ALTER TABLE ativo ADD COLUMN ativo BOOLEAN NOT NULL DEFAULT TRUE;");
          
         
          
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->execute("ALTER TABLE ativo DROP COLUMN ativo;");
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
