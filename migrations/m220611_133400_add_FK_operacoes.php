<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\financas\Proventos;
use app\lib\dicionario\ProventosMovimentacao;

/**
 * type 1 são os pápeis 
 * type 2 são as regras
 * 
 */
class m220611_133400_add_FK_operacoes extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

     $this->execute("ALTER TABLE operacao
        ADD CONSTRAINT fk_itens_ativos FOREIGN KEY (itens_ativos_id) REFERENCES itens_ativo (id);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
     return true;
    }
}
