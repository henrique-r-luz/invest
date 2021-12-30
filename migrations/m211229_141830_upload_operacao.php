<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;
use app\models\financas\Operacao;
use app\models\financas\Proventos;
use app\models\financas\ItensAtivo;

/**
 * Class m190609_143226_inicio
 */
class m211229_141830_upload_operacao extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute("CREATE table operacoes_import(
            id SERIAL PRIMARY KEY,
            investidor_id INTEGER REFERENCES investidor(id) NOT NULL,
            arquivo text,
            tipo_arquivo text,
            lista_operacoes_criadas_json text
        );");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP table operacoes_import");
    }
}
