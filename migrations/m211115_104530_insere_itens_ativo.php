<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;
use app\models\financas\Investidor;
use app\models\financas\Operacao;

/**
 * Class m190609_143226_inicio
 */
class m211115_104530_insere_itens_ativo extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE table itens_ativo(
                        id SERIAL PRIMARY KEY,
                        ativo_id INTEGER REFERENCES ativo(id) NOT NULL,
                        investidor_id INTEGER REFERENCES investidor(id) NOT NULL,
                        quantidade numeric,
                        valor_compra real,
                        valor_liquido real,
                        valor_bruto real,
                        ativo boolean
           );");
           $this->execute("CREATE UNIQUE INDEX intes_ativo_unique_investidor ON  itens_ativo (investidor_id,ativo_id);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("drop table itens_ativo;");
    }
}
