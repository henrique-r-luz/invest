<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\Tipo;
use app\lib\Categoria;

/**
 * Class m190609_143226_inicio
 */
class m200307_173226_remove_table_categoria extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

         //cria enum categória
       $this->execute("CREATE TYPE tipo_enum AS ENUM('Tesouro direto','Fundos de investomento','CDB','Debêntures','Ações');");
       //cria coluna na tabela tivo para o novo enum
       $this->execute("ALTER TABLE ativo ADD COLUMN tipo categoria_enum;");
       $tipos = Tipo::find()->all();
       foreach ($tipos as $tipo){
           if($tipo->tipo_id==2){
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
       
        return true;
    }

}
