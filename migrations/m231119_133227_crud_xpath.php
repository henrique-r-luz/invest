<?php

namespace app\migrations;

use yii\db\Schema;
use yii\db\Migration;

/**
 */
class m231119_133227_crud_xpath extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable(
            'xpath_bot',
            [
                'id' => Schema::TYPE_PK,
                'site_acao_id' => Schema::TYPE_INTEGER . ' NOT NULL ',
                'data' => Schema::TYPE_DATE . ' NOT NULL',
                'xpath' => Schema::TYPE_TEXT . ' NOT NULL ',
            ]
        );

        $this->addForeignKey(
            'xpath_invest_site_acao_id_fk',
            'xpath_bot',
            'site_acao_id',
            'site_acoes',
            'ativo_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('xpath_invest_site_acao_id_fk', 'xpath_bot');
        $this->dropTable('xpath_bot');
    }
}
