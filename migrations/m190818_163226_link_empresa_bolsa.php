<?php



namespace app\migrations;


use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m190818_163226_link_empresa_bolsa extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
         $this->execute(
                "ALTER TABLE ativo ADD COLUMN  acao_bolsa_id INTEGER REFERENCES acao_bolsa(id);");
            
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        $this->execute("ALTER TABLE acao_bolsa_id DROP COLUMN ativo;");
        return true;
    }
}
