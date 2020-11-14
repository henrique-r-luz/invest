<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\financas\Ativo;
use app\lib\Categoria;

/**
 * Class m190609_143226_inicio
 */
class m200307_183226_ajusta_tipo extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {

         //cria enum categória
       $this->execute("CREATE TYPE tipo_enum AS ENUM('Tesouro Direto','Fundos de Investimentos','CDB','Debêntures','Ações');");
       //cria coluna na tabela tivo para o novo enum
       $this->execute("ALTER TABLE ativo ADD COLUMN tipo tipo_enum;");
       $ativos = Ativo::find()->all();
       foreach ($ativos as $ativo){
           switch ($ativo->tipo_id){
               case  2:
                    $ativo->tipo = \app\lib\Tipo::TESOURO_DIRETO;
                    break;
                
                case  3:
                    $ativo->tipo = \app\lib\Tipo::FUNDOS_INVESTIMENTO;
                    break;
                
                case  4:
                    $ativo->tipo = \app\lib\Tipo::CDB;
                    break;
                
                case  6:
                    $ativo->tipo = \app\lib\Tipo::DEBENTURES;
                    break;
                
                case  7:
                    $ativo->tipo = \app\lib\Tipo::ACOES;
                    break;
           }
           $ativo->save();
       }
       
       //remove categoria_id
       $this->execute("alter table ativo drop column tipo_id;");
       //remove tabela tipo
       $this->execute("drop table tipo;");
       

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
       
        return true;
    }

}
