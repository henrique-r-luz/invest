<?php

namespace app\migrations;


use yii\db\Migration;

/**
 */
class m240202_143227_add_preco_medio extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('public.operacao', 'valor', 'numeric');
        $this->addColumn('public.operacao', 'preco_medio', 'numeric');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('public.operacao', 'preco_medio');
        $this->alterColumn('public.operacao', 'valor', 'real');
    }
}
