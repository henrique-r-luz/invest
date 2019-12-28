<?php

namespace app\models;

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
            [['codigo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'cnpj'=>'Cnpj',
            'id' => 'ID',
            'nome' => 'Nome',
            'codigo' => 'Código',
            'setor' => 'Setor',
        ];
    }
}