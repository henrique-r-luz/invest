<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\Ativo;
use app\lib\Categoria;

/**
 * Class m190609_143226_inicio
 */
class m200321_113226_notificacao extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        //remove index antigo
        $this->execute("CREATE TABLE notificacao (
                    id SERIAL PRIMARY KEY,
                    user_id integer NOT NULL,
                    dados jsonb NOT NULL,
                    lido  BOOLEAN DEFAULT false NOT NULL,
                    created_at INTEGER NOT NULL,
                    updated_at INTEGER NOT NULL
                );");

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        $this->execute("drop table notificacao;");
        return true;
    }

}
