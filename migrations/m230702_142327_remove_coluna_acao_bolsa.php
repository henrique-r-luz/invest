<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m230702_142327_remove_coluna_acao_bolsa extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('acao_bolsa', 'tag_along_on');
        $this->dropColumn('acao_bolsa', 'free_float');
        $this->dropColumn('acao_bolsa', 'governo');
        $this->dropColumn('acao_bolsa', 'rank_ano');
        $this->dropColumn('acao_bolsa', 'rank_trimestre');
        $this->dropColumn('acao_bolsa', 'data_atualizacao_rank');
        $this->dropColumn('acao_bolsa', 'habilita_rank');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('acao_bolsa', 'tag_along_on', 'smallint');
        $this->addColumn('acao_bolsa', 'free_float', 'smallint');
        $this->addColumn('acao_bolsa', 'governo', 'boolean');
        $this->addColumn('acao_bolsa', 'rank_ano', 'smallint');
        $this->addColumn('acao_bolsa', 'rank_trimestre', 'smallint');
        $this->addColumn('acao_bolsa', 'data_atualizacao_rank', 'smallint');
        $this->addColumn('acao_bolsa', 'habilita_rank', 'boolean');
    }
}
