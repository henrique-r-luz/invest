<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m200801_143226_altera_cidogo_acao_empresa extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TABLE public.acao_bolsa
                            ALTER COLUMN codigo  type character varying(5);");

    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
