<?php



namespace app\migrations;


use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m190909_163226_balanco_empresa_bolsa extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        
         $this->execute(
                "CREATE TABLE balanco_empresa_bolsa (
                    id SERIAL PRIMARY KEY,
                    cnpj text not null,
                    tag_along_on smallint,
                    free_float_on smallint,
                    governo boolean,
                    data text,
                    patrimonio_liquido real,
                    receita_liquida real,
                    ebitda real,
                    DA real,
                    ebit real,
                    margem_ebit smallint,
                    resultado_financeiro real,
                    imposto real,
                    lucro_liquido real,
                    margem_liquida smallint,
                    roe smallint,
                    caixa real,
                    divida_bruta real,
                    divida_liquida real ,
                    divida_bruta_patrimonio smallint,
                    divida_liquida_ebitda real,
                    fco real,
                    capex real,
                    fcf real,
                    fcl real,
                    capex_fco smallint,
                    proventos real,
                    payout smallint,
                    anual smallint
                );");
          $this->execute("CREATE UNIQUE INDEX unique_balanco_cnpj ON  balanco_empresa_bolsa (cnpj);");
            
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {

      $this->execute("DROP table balanco_empresa_bolsa CASCADE;");
        return true;
    }
}
