<?php

namespace app\migrations;

use app\models\config\ClassesOperacoes;
use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m230601_153627_add_site_acoes extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameTable('public.atualiza_acao', 'site_acoes');
        $classesOperacoes = ClassesOperacoes::find()->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimetica'])->one();
        $classesOperacoes->nome = 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimeticaCDBInter';
        $classesOperacoes->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameTable('public.site_acoes', 'atualiza_acao');
        $classesOperacoes = ClassesOperacoes::find()->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimeticaCDBInter'])->one();
        $classesOperacoes->nome = 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimetica';
        $classesOperacoes->save();
    }
}
