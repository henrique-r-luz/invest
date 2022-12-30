<?php

namespace app\migrations;

use app\lib\dicionario\Categoria;
use yii\db\Migration;
use app\models\config\ClassesOperacoes;
use app\models\financas\Ativo;


class m221229_143400_insere_classes_operacoes extends Migration
{

    private $classeRendaVariavel  = 'app\lib\config\atualizaAtivos\RendaVariavel';
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // $ativos =  Ativo::find()->all();
        $this->execute("CREATE UNIQUE INDEX IF NOT EXISTS classe_operacoes_unique
        ON public.classes_operacoes USING btree
        (nome ASC NULLS LAST)
        TABLESPACE pg_default;
    ");
        $this->insert('public.classes_operacoes', ['nome' => $this->classeRendaVariavel]);
        foreach (Ativo::find()->each(20) as $ativo) {
            if ($ativo->categoria == Categoria::RENDA_VARIAVEL) {
                $this->update(
                    'public.ativo',
                    ['classe_atualiza_id' => ClassesOperacoes::find()->where(['nome' => $this->classeRendaVariavel])->one()->id],
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

        $this->update('public.ativo', ['classe_atualiza_id' => null], ['categoria' => Categoria::RENDA_VARIAVEL]);
        $this->delete('public.classes_operacoes', ['nome' => $this->classeRendaVariavel]);
        $this->execute("DROP INDEX IF EXISTS public.classe_operacoes_unique;");
    }
}
