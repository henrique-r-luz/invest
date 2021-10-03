<?php

namespace app\models\financas;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "proventos".
 *
 * @property int $id
 * @property int $ativo_id
 * @property string $data
 * @property float $valor
 *
 * @property Ativo $ativo
 */
class Proventos extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proventos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ativo_id', 'data', 'valor'], 'required'],
            [['ativo_id'], 'default', 'value' => null],
            [['ativo_id'], 'integer'],
            [['data'], 'safe'],
            [['valor'], 'number'],
            [['ativo_id', 'data'], 'unique', 'targetAttribute' => ['ativo_id', 'data']],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ativo_id' => 'Ativos',
            'data' => 'Data',
            'valor' => 'Valor',
        ];
    }

    /**
     * Gets query for [[Ativo]].
     *
     * @return ActiveQuery
     */
    public function getAtivo()
    {
        return $this->hasOne(Ativo::className(), ['id' => 'ativo_id']);
    }
}
