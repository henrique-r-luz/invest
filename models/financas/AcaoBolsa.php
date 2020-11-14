<?php

namespace app\models\financas;

use Yii;

/**
 * This is the model class for table "acao_bolsa".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property string $setor
 */
class AcaoBolsa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acao_bolsa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'setor','cnpj'], 'required'],
            [['nome', 'setor','cnpj'], 'string'],
            [['rank_ano','rank_trimestre'],'number'],
            [['codigo'], 'unique'],
            [['habilita_rank'],'boolean']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cnpj'=>'Registro Empresa (CPNJ,IRS)',
            'id' => 'ID',
            'nome' => 'Nome',
            'codigo' => 'Código',
            'setor' => 'Setor',
            'rank_ano' => 'Rank Ano',
            'rank_trimestre'=>'Rank trimestre'
        ];
    }
}
