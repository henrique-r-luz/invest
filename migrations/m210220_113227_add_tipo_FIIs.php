<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m210220_113227_add_tipo_FIIs extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TYPE public.tipo_enum  ADD VALUE 'FIIs' AFTER 'ETFs';");
      
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
