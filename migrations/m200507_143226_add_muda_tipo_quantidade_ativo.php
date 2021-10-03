<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m200507_143226_add_muda_tipo_quantidade_ativo extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TABLE public.ativo
                            ALTER COLUMN quantidade  TYPE numeric;");

    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
