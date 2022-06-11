<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;

/**
 * Class m190609_143226_inicio
 */
class m210721_114530_unique_ativo extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
           $this->execute("drop index IF EXISTS ativo_codigo;");
           $this->execute("CREATE UNIQUE INDEX ativo_codigo_investidor ON  ativo (codigo,investidor_id);");
       
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        return true;
    }

}
