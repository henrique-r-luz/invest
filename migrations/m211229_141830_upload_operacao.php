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
            arquivo text not null,
            extensao text not null,
            tipo_arquivo text not null,
            hash_nome text not null,
            lista_operacoes_criadas_json text -- operações que serão criadas pelo arquivo
        );");

        $this->execute("CREATE UNIQUE INDEX unique_hash_investido ON operacoes_import (investidor_id,hash_nome);");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("DROP table operacoes_import");
    }
}
