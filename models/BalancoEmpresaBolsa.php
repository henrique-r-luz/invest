<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "balanco_empresa_bolsa".
 *
 * @property int $id
 * @property string $cnpj
 * @property int $tag_along_on
 * @property int $free_float_on
 * @property bool $governo
 * @property string $data
 * @property double $patrimonio_liquido
 * @property double $receita_liquida
 * @property double $ebitda
 * @property double $da
 * @property double $ebit
 * @property int $margem_ebit
 * @property double $resultado_financeiro
 * @property double $imposto
 * @property double $lucro_liquido
 * @property int $margem_liquida
 * @property int $roe
 * @property double $caixa
 * @property double $divida_bruta
 * @property double $divida_liquida
 * @property int $divida_bruta_patrimonio
 * @property double $divida_liquida_ebitda
 * @property double $fco
 * @property double $capex
 * @property double $fcf
 * @property double $fcl
 * @property int $capex_fco
 * @property double $proventos
 * @property int $payout
 * @property int $anual
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
            [['cnpj'], 'required'],
            [['cnpj', 'data'], 'string'],
            [['tag_along_on', 'free_float_on', 'margem_ebit', 'margem_liquida', 'roe', 'divida_bruta_patrimonio', 'capex_fco', 'payout', 'anual'], 'default', 'value' => null],
            [['tag_along_on', 'free_float_on', 'margem_ebit', 'margem_liquida', 'roe', 'divida_bruta_patrimonio', 'capex_fco', 'payout', 'anual'], 'integer'],
            [['governo'], 'boolean'],
            [['patrimonio_liquido', 'receita_liquida', 'ebitda', 'da', 'ebit', 'resultado_financeiro', 'imposto', 'lucro_liquido', 'caixa', 'divida_bruta', 'divida_liquida', 'divida_liquida_ebitda', 'fco', 'capex', 'fcf', 'fcl', 'proventos'], 'number'],
            [['cnpj'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cnpj' => 'Cnpj',
            'tag_along_on' => 'Tag Along On',
            'free_float_on' => 'Free Float On',
            'governo' => 'Governo',
            'data' => 'Data',
            'patrimonio_liquido' => 'Patrimonio Liquido',
            'receita_liquida' => 'Receita Liquida',
            'ebitda' => 'Ebitda',
            'da' => 'Da',
            'ebit' => 'Ebit',
            'margem_ebit' => 'Margem Ebit',
            'resultado_financeiro' => 'Resultado Financeiro',
            'imposto' => 'Imposto',
            'lucro_liquido' => 'Lucro Liquido',
            'margem_liquida' => 'Margem Liquida',
            'roe' => 'Roe',
            'caixa' => 'Caixa',
            'divida_bruta' => 'Divida Bruta',
            'divida_liquida' => 'Divida Liquida',
            'divida_bruta_patrimonio' => 'Divida Bruta Patrimonio',
            'divida_liquida_ebitda' => 'Divida Liquida Ebitda',
            'fco' => 'Fco',
            'capex' => 'Capex',
            'fcf' => 'Fcf',
            'fcl' => 'Fcl',
            'capex_fco' => 'Capex Fco',
            'proventos' => 'Proventos',
            'payout' => 'Payout',
            'anual' => 'Anual',
        ];
    }
}
