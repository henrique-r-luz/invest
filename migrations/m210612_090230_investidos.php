<?php

namespace app\migrations;

use yii\db\Migration;
use \app\models\financas\Ativo;


/**
 * Class m190609_143226_inicio
 */
class m210612_090230_investidos extends Migration {

    /**
     * {@inheritdoc}
     */
    public function Up() {
        
        $this->execute(
                "CREATE TABLE investidor (
                    id SERIAL PRIMARY KEY,
                    cpf varchar(11) NOT NULL UNIQUE,
                    nome text NOT NULL
                );
        ");
        //altera coluna ativos
        $this->execute("ALTER TABLE ativo ADD COLUMN investidor_id INTEGER;");
        $this->execute("ALTER TABLE ativo 
                        ADD CONSTRAINT fk_investido_id
                        FOREIGN KEY (investidor_id) 
                        REFERENCES investidor(id);");
        
        //insere investidor 
        $this->insert('investidor', ['cpf'=>'01909375560','nome'=>'Henrique luz']);
        $this->insert('investidor', ['cpf'=>'01977474602','nome'=>'Clara Lima']);
        
       /* $ativos  = Ativo::find()->all();
        foreach( $ativos as $ativo){
             $this->insert('tecnico.tipo_carga_horaria_matriz', ['carga_horaria' => $matriz->ch_atividade_complementar,
                'tipo_carga_horaria_id' => TipoCargaHoraria::find()->where(['nome' => 'ATIVIDADE COMPLEMTAR'])->one()->id,
                'matriz_id' => $matriz->id, 'created_at' => $this->data, 'updated_at' => $this->data,
                'created_by' => $this->user, 'updated_by' => $this->user]);
            $this->update('ativo',[],['id'=>$ativo->id]);
        }*/
        
       // $this->execute("CREATE UNIQUE INDEX ativo_data_provento ON  proventos (ativo_id,data);");
      
    }

    /**
     * {@inheritdoc}
     */
    public function Down() {
     
       $this->execute("ALTER TABLE ativo DROP COLUMN investidor_id;"); 
       $this->execute("DROP table investidor CASCADE;");
    }

}
