<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m210206_113227_add_tipo_ETFs extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TYPE public.tipo_enum  ADD VALUE 'ETFs' AFTER 'Prata';");
      
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
