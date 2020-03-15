<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\Ativo;
use app\lib\Categoria;

/**
 * Class m190609_143226_inicio
 */
class m200315_203226_rank extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        //remove index antigo
        $this->execute("alter TABLE acao_bolsa 
                        ADD COLUMN rank_ano real,
                        ADD COLUMN rank_trimestre real,
                        ADD COLUMN data_atualizacao_rank timestamp,
                        ADD COLUMN habilita_rank boolean DEFAULT TRUE;
                        ");
        // 
      
        

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->execute("alter table acao_bolsa drop column rank_ano;");
        $this->execute("alter table acao_bolsa drop column rank_trimestre;");
        $this->execute("alter table acao_bolsa drop column data_atualizacao_rank;");
        return true;
    }

}
