<?php

namespace app\migrations;

use app\lib\dicionario\Categoria;
use app\models\config\ClassesOperacoes;
use app\models\financas\Ativo;
use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m230604_192427_alteraClassOperacoes extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $calculaAritimeticaCDBInter = ClassesOperacoes::find()
            ->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimeticaCDBInter'])
            ->one();
        $calculaAritimeticaCDBInter->nome = 'app\lib\config\atualizaAtivos\rendaFixa\cdbInter\CalculaAritimeticaCDBInter';
        $calculaAritimeticaCDBInter->save();

        $calculaAritimetica = new ClassesOperacoes();
        $calculaAritimetica->nome = 'app\lib\config\atualizaAtivos\rendaFixa\normais\CalculaAritimetica';
        $calculaAritimetica->save();


        /**
         * Atualiza Ativos
         */
        $ativos = Ativo::find()
            ->where(['categoria' => Categoria::RENDA_FIXA])
            ->andWhere(['<>', 'classe_atualiza_id', $calculaAritimeticaCDBInter->id]);

        foreach ($ativos->each(20) as $ativo) {
            $ativo->classe_atualiza_id = $calculaAritimetica->id;
            $ativo->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $calculaPorMediaPreco = ClassesOperacoes::find()
            ->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\cdbInter\CalculaPorMediaPreco'])
            ->one();

        $calculaAritimeticaCDBInter = ClassesOperacoes::find()
            ->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\cdbInter\CalculaAritimeticaCDBInter'])
            ->one();

        /**
         * Atualiza Ativos
         */
        $ativos = Ativo::find()
            ->where(['categoria' => Categoria::RENDA_FIXA])
            ->andWhere(['<>', 'classe_atualiza_id', $calculaAritimeticaCDBInter->id]);

        foreach ($ativos->each(20) as $ativo) {
            $ativo->classe_atualiza_id = $calculaPorMediaPreco->id;
            $ativo->save();
        }

        /**
         * altera caminho da CalculaAritimeticaCDBInter
         */

        $calculaAritimeticaCDBInter->nome = 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimeticaCDBInter';
        $calculaAritimeticaCDBInter->save();

        /**
         * remove  CalculaAritimetica
         */
        $calculaAritimetica = ClassesOperacoes::find()
            ->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\normais\CalculaAritimetica'])
            ->one();
        $calculaAritimetica->delete();
    }
}
