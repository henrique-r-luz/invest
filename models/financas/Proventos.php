<?php

namespace app\models\financas;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\lib\behavior\AuditoriaBehavior;

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
            AuditoriaBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['itens_ativos_id', 'data', 'valor','movimentacao'], 'required'],
            [['itens_ativos_id'], 'default', 'value' => null],
            [['itens_ativos_id'], 'integer'],
            [['data'], 'safe'],
            [['valor'], 'number'],
            [['itens_ativos_id', 'data','movimentacao'], 'unique', 'targetAttribute' => ['itens_ativos_id', 'data','movimentacao']],
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
            'movimentacao'=>'Movimentação'
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
