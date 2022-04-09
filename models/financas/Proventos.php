<?php

namespace app\models\financas;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use ruturajmaniyar\mod\audit\behaviors\AuditEntryBehaviors;

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

    public function behaviors()
    {
        return [
            'auditEntryBehaviors' => [
                'class' => AuditEntryBehaviors::class
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itens_ativos_id', 'data', 'valor'], 'required'],
            [['itens_ativos_id'], 'default', 'value' => null],
            [['itens_ativos_id'], 'integer'],
            [['data'], 'safe'],
            [['valor'], 'number'],
            [['itens_ativos_id', 'data'], 'unique', 'targetAttribute' => ['itens_ativos_id', 'data']],
            [['itens_ativos_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItensAtivo::className(), 'targetAttribute' => ['itens_ativos_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'itens_ativos_id' => 'Ativos',
            'data' => 'Data',
            'valor' => 'Valor',
        ];
    }

    /**
     * Gets query for [[Ativo]].
     *
     * @return ActiveQuery
     */
    public function getItensAtivo()
    {
        return $this->hasOne(ItensAtivo::className(), ['id' => 'itens_ativos_id']);
    }
}
