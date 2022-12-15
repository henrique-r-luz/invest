<?php

namespace app\models\sincronizar;

use Yii;
use app\models\financas\Ativo;

/**
 * This is the model class for table "preco".
 *
 * @property int $id
 * @property float $valor
 * @property int|null $ativo_id
 *
 * @property Ativo $ativo
 */
class Preco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor', 'data'], 'required'],
            [['valor'], 'number'],
            [['ativo_id'], 'default', 'value' => null],
            [['ativo_id'], 'integer'],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'valor' => 'Valor',
            'ativo_id' => 'Ativo',
        ];
    }

    /**
     * Gets query for [[Ativo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtivo()
    {
        return $this->hasOne(Ativo::className(), ['id' => 'ativo_id']);
    }
}
