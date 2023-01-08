<?php

namespace app\migrations;

use app\lib\dicionario\Categoria;
use yii\db\Migration;
use app\models\config\ClassesOperacoes;
use app\models\financas\Ativo;


class m230108_153400_insere_classes_operacoes extends Migration
{

    private $classeRendaFixa  = 'app\lib\config\atualizaAtivos\rendaFixa\RendaFixa';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $ativos =  Ativo::find()->all();

        $this->insert('public.classes_operacoes', ['nome' => $this->classeRendaFixa]);
        foreach (Ativo::find()->each(20) as $ativo) {
            if ($ativo->categoria == Categoria::RENDA_FIXA) {
                $this->update(
                    'public.ativo',
                    ['classe_atualiza_id' => ClassesOperacoes::find()->where(['nome' => $this->classeRendaFixa])->one()->id],
                    ['id' => $ativo->id]
                );
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->update('public.ativo', ['classe_atualiza_id' => null], ['categoria' => Categoria::RENDA_FIXA]);
        $this->delete('public.classes_operacoes', ['nome' => $this->classeRendaFixa]);
    }
}
