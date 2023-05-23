<?php

namespace app\migrations;

use yii\db\Migration;

class m230523_103400_remove_tabela_preco_medio extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable("public.preco_medio_venda");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute(
            "CREATE TABLE IF NOT EXISTS public.preco_medio_venda
            (
                valor numeric NOT NULL,
                operacoes_id integer NOT NULL,
                CONSTRAINT preco_medio_venda_pk PRIMARY KEY (operacoes_id),
                CONSTRAINT operacao_preco_media_id_fk FOREIGN KEY (operacoes_id)
                    REFERENCES public.operacao (id) MATCH SIMPLE
                    ON UPDATE NO ACTION
                    ON DELETE NO ACTION
            )"
        );
    }
}
