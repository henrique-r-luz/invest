<?php

namespace app\models\financas;

use Yii;

/**
 * This is the model class for table "investidor".
 *
 * @property int $id
 * @property string $cpf
 * @property string $nome
 *
 * @property Ativo[] $ativos
 */
class Investidor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'investidor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cpf', 'nome'], 'required'],
            [['nome'], 'string'],
            [['cpf'], 'string'],
            [['cpf'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cpf' => 'CPF',
            'nome' => 'Nome',
        ];
    }

    /**
     * Gets query for [[Ativos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtivos()
    {
        return $this->hasMany(Ativo::className(), ['investidor_id' => 'id']);
    }
}
