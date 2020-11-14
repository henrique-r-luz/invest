<?php

namespace app\migrations;

use yii\db\Migration;
use app\models\financas\Ativo;
use app\lib\Categoria;

/**
 * Class m190609_143226_inicio
 */
class m200310_203226_ajusta_balanco extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
        //remove index antigo
        $this->execute("DROP INDEX balanco_data_empresa;");
        // 
        $this->execute("alter table balanco_empresa_bolsa add column trimestre boolean");
        
        $this->execute("CREATE UNIQUE INDEX balanco_data_empresa ON  balanco_empresa_bolsa(codigo,data,trimestre);");
        

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
       
        return true;
    }

}
