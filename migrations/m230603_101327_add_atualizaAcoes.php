<?php

namespace app\migrations;

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m190609_143226_inicio
 */
class m230603_101327_add_atualizaAcoes extends Migration
{

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('public.balanco_empresa_bolsa');
        /**
         * O atributo ativo_atualizado possui a seguinte estrutura
         * [
         *  'ativo_id'=>20,
         *  'status'=>true,  // true indica se o ativo foi atualizado
         *  'erro' =>'o erro se ocorreu' // informa qual foi o erro na atualização  
         * ] 
         */
        $this->createTable(
            'atualiza_acoes',
            [
                'id' => Schema::TYPE_PK,
                'data' => ' timestamp without time zone NOT NULL ',
                'ativo_atulizado' => ' jsonb ',
                'status' => Schema::TYPE_TEXT . ' NOT NULL ',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute("CREATE TABLE IF NOT EXISTS public.balanco_empresa_bolsa
        (
            id serial,
            data text,
            patrimonio_liquido real,
            receita_liquida real,
            ebitda real,
            da real,
            ebit real,
            margem_ebit real,
            resultado_financeiro real,
            imposto real,
            lucro_liquido real,
            margem_liquida real,
            roe real,
            caixa real,
            divida_bruta real,
            divida_liquida real,
            divida_bruta_patrimonio real,
            divida_liquida_ebitda real,
            fco real,
            capex real,
            fcf real,
            fcl real,
            fcl_capex real,
            proventos real,
            payout real,
            pdd real,
            pdd_lucro_liquido real,
            indice_basileia real,
            codigo character varying(4),
            trimestre boolean,
            CONSTRAINT balanco_empresa_bolsa_pkey PRIMARY KEY (id),
            CONSTRAINT balanco_empresa_bolsa_codigo_fkey FOREIGN KEY (codigo)
                REFERENCES public.acao_bolsa (codigo) MATCH SIMPLE
                ON UPDATE NO ACTION
                ON DELETE NO ACTION
        )");

        $this->dropTable('atualiza_acoes');
    }
}
