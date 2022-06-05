<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\financas\Proventos;
use app\lib\dicionario\ProventosMovimentacao;

/**
 * type 1 são os pápeis 
 * type 2 são as regras
 * 
 */
class m220531_202830_add_movimentacao_proventos extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->execute('ALTER TABLE proventos
                        ADD CONSTRAINT itens_ativos_proventos_fk 
                        FOREIGN KEY (itens_ativos_id) 
                        REFERENCES  itens_ativo (id);');

     $this->addColumn('proventos', 'movimentacao', 'integer');
       $this->execute('CREATE UNIQUE INDEX unique_mv_data_ativo
                        ON proventos(data,itens_ativos_id,movimentacao);');

        $proventos = Proventos::find()->all();
        foreach ($proventos as $provento) {
            $this->update(
                'proventos',
                ['movimentacao' => ProventosMovimentacao::getId(ProventosMovimentacao::Dividendo)],
                ['id' => $provento->id]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

        $this->execute('DROP INDEX IF EXISTS public.unique_mv_data_ativo');
        $this->dropColumn('proventos', 'movimentacao');
        //return true;
    }
}
