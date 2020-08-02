<?php

namespace app\migrations;

use yii\db\Migration;


/**
 * Class m190609_143226_inicio
 */
class m200801_143227_insere_pais_ativo extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute("ALTER TABLE public.ativo
                            add COLUMN pais  character varying(2) NOT NULL DEFAULT 'BR';");

    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
       return true;
    }

}
