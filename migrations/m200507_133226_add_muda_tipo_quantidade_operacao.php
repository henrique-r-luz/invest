<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m200507_133226_add_muda_tipo_quantidade_operacao extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TABLE public.operacao
                            ALTER COLUMN quantidade  TYPE numeric;");

    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
