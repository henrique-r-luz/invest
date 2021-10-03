<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m200507_113226_add_tipo_criptomoedas extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TYPE public.tipo_enum  ADD VALUE 'Criptomoeda' AFTER 'Ações';");

    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
