<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m210206_113226_add_tipo_metais extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TYPE public.tipo_enum  ADD VALUE 'Ouro' AFTER 'Criptomoeda';");
        $this->execute("ALTER TYPE public.tipo_enum  ADD VALUE 'Prata' AFTER 'Ouro';");

    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
