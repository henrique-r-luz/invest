<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balanco_empresa_bolsa".
 *
 * @property int $id
 * @property string|null $data
 * @property float|null $patrimonio_liquido
 * @property float|null $receita_liquida
 * @property float|null $ebitda
 * @property float|null $da
 * @property float|null $ebit
 * @property int|null $margem_ebit
 * @property float|null $resultado_financeiro
 * @property float|null $imposto
 * @property float|null $lucro_liquido
 * @property int|null $margem_liquida
 * @property int|null $roe
 * @property float|null $caixa
 * @property float|null $divida_bruta
 * @property float|null $divida_liquida
 * @property int|null $divida_bruta_patrimonio
 * @property float|null $divida_liquida_ebitda
 * @property float|null $fco
 * @property float|null $capex
 * @property float|null $fcf
 * @property float|null $fcl
 * @property int|null $fcl_capex
 * @property float|null $proventos
 * @property int|null $payout
 * @property float|null $pdd
 * @property float|null $pdd_lucro_liquido
 * @property float|null $indice_basileia
 * @property string|null $codigo
 *
 * @property AcaoBolsa $codigo0
 */
class BalancoEmpresaBolsa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'balanco_empresa_bolsa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'string'],
            [['roe', 'divida_bruta_patrimonio', 'fcl_capex', 'payout','margem_ebit', 'margem_liquida','patrimonio_liquido', 'receita_liquida', 'ebitda', 'da', 'ebit', 'resultado_financeiro', 'imposto', 'lucro_liquido', 'caixa', 'divida_bruta', 'divida_liquida', 'divida_liquida_ebitda', 'fco', 'capex', 'fcf', 'fcl', 'proventos', 'pdd', 'pdd_lucro_liquido', 'indice_basileia'], 'number'],
            [['margem_ebit', 'margem_liquida', 'roe', 'divida_bruta_patrimonio', 'fcl_capex', 'payout'], 'default', 'value' => null],
            [['codigo'], 'string', 'max' => 4],
           // [['codigo'], 'exist', 'skipOnError' => true, 'targetClass' => AcaoBolsa::className(), 'targetAttribute' => ['codigo' => 'codigo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'patrimonio_liquido' => 'Patrimônio Líquido',
            'receita_liquida' => 'Receita Líquida',
            'ebitda' => 'Ebitda',
            'da' => 'Da',
            'ebit' => 'Ebit',
            'margem_ebit' => 'Margem Ebit',
            'resultado_financeiro' => 'Resultado Financeiro',
            'imposto' => 'Imposto',
            'lucro_liquido' => 'Lucro Líquido',
            'margem_liquida' => 'Margem Líquida',
            'roe' => 'Roe',
            'caixa' => 'Caixa',
            'divida_bruta' => 'Divida Bruta',
            'divida_liquida' => 'Divida Líquida',
            'divida_bruta_patrimonio' => 'Divida Bruta Patrimônio',
            'divida_liquida_ebitda' => 'Divida Líquida Ebitda',
            'fco' => 'Fco',
            'capex' => 'Capex',
            'fcf' => 'Fcf',
            'fcl' => 'Fcl',
            'fcl_capex' => 'Fcl Capex',
            'proventos' => 'Proventos',
            'payout' => 'Payout',
            'pdd' => 'Pdd',
            'pdd_lucro_liquido' => 'Pdd Lucro Líquido',
            'indice_basileia' => 'Índice Basiléia',
            'codigo' => 'Codigo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCodigo0()
    {
        return $this->hasOne(AcaoBolsa::className(), ['codigo' => 'codigo']);
    }
}
