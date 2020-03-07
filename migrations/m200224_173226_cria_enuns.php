<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\Ativo;
use app\lib\Categoria;

/**
 * Class m190609_143226_inicio
 */
class m200224_173226_cria_enuns extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

        //cria enum categória
       $this->execute("CREATE TYPE categoria_enum AS ENUM('Renda Fixa','Renda Variável');");
       //cria coluna na tabela tivo para o novo enum
       $this->execute("ALTER TABLE ativo ADD COLUMN categoria categoria_enum;");
       $ativos = Ativo::find()->all();
       foreach ($ativos as $ativo){
           if($ativo->categoria_id==2){
               $ativo->categoria = Categoria::RENDA_VARIAVEL;
           }else{
               $ativo->categoria = Categoria::RENDA_FIXA;
           }
           $ativo->save();
       }
       
       //remove categoria_id
       $this->execute("alter table ativo drop column categoria_id;");
       
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
         $this->execute("alter table ativo drop column categoria;");
        $this->execute("DROP TYPE categoria_enum;");
        return true;
    }

}
