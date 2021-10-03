<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m210211_113227_add_atualiza_acao extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {

        $this->execute(
                "CREATE TABLE atualiza_acao (
                    ativo_id INTEGER PRIMARY KEY REFERENCES ativo(id) NOT NULL,
                    url text not null
                );"
        );
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
        $this->execute("DROP table atualiza_acao CASCADE;");
    }

}
