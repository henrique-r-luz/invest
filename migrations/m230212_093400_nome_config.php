<?php

namespace app\migrations;

use app\lib\dicionario\Categoria;
use yii\db\Migration;
use app\models\config\ClassesOperacoes;
use app\models\financas\Ativo;

class m230212_093400_nome_config extends Migration
{


    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $configVariavel = ClassesOperacoes::find()->where(['nome' => 'app\lib\config\atualizaAtivos\rendaVariavel\RendaVariavel'])->one();
        $configVariavel->nome = 'app\lib\config\atualizaAtivos\rendaVariavel\CalculaPorMediaPreco';
        $configVariavel->save();
        $configFixa = ClassesOperacoes::find()->where(['nome' => 'app\lib\config\atualizaAtivos\rendaFixa\RendaFixa'])->one();
        $configFixa->nome = 'app\lib\config\atualizaAtivos\rendaFixa\CalculaAritimetica';
        $configFixa->save();

        $ativos = Ativo::find()->where(['categoria' => Categoria::RENDA_FIXA])->all();
        foreach ($ativos as $ativo) {
            if ($ativo->id != 33) {
                $this->update('ativo', ['classe_atualiza_id' => $configVariavel->id], ['id' => $ativo->id]);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        return false;
    }
}
