<?php

namespace app\migrations;

use yii\db\Migration;
use yii\db\Schema;

/**
 * 
 */
class m220301_200630_adiciona_tipo_atualizacao extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('itens_ativo','sicroniza_ativo_upload',Schema::TYPE_TEXT);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('itens_ativo','sicroniza_ativo_upload');
    }
}
