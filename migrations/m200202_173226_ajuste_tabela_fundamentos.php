<?php

namespace app\migrations;

use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m200202_173226_ajuste_tabela_fundamentos extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {


        //altera tipo da coluna codigo da tabela acao_bolsa
        $this->execute("ALTER TABLE acao_bolsa ALTER COLUMN codigo TYPE varchar(4) using left(codigo, 4);");
        $this->execute("CREATE UNIQUE INDEX bolsa_acao_codigo ON  acao_bolsa(codigo);");
        //ajusta atributos da tabela balanco_empresa_bolsa
        $this->execute("ALTER TABLE balanco_empresa_bolsa DROP COLUMN anual;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa RENAME COLUMN capex_fco  TO fcl_capex;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa ADD COLUMN PDD real;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa ADD COLUMN PDD_lucro_liquido real;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa ADD COLUMN indice_basileia real;");
        //ajusta atributos da tabela acao_bolsa
        $this->execute("ALTER TABLE acao_bolsa ADD COLUMN tag_along_on smallint;");
        $this->execute("ALTER TABLE acao_bolsa ADD COLUMN free_float smallint;");
        $this->execute("ALTER TABLE acao_bolsa ADD COLUMN governo boolean;");
        //remove atributos desnecessário da tabela balanco_empresa_bolsa
        $this->execute("ALTER TABLE balanco_empresa_bolsa drop COLUMN tag_along_on;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa drop COLUMN free_float_on;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa drop COLUMN governo;");
        //altera relacionamenbto balanco_empresa_bolsa com acao_bolsa
        $this->execute("ALTER TABLE balanco_empresa_bolsa DROP COLUMN cnpj CASCADE;");
        $this->execute("ALTER TABLE balanco_empresa_bolsa ADD COLUMN codigo varchar(4);");
        $this->execute("ALTER TABLE balanco_empresa_bolsa add FOREIGN KEY (codigo) REFERENCES acao_bolsa (codigo);");
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

        // remove altera tipo da coluna codigo da tabela acao_bolsa
        $this->execute("DROP INDEX bolsa_acao_codigo;");
        $this->execute("ALTER TABLE acao_bolsa ALTER COLUMN codigo TYPE text;");
        return true;
    }

}
