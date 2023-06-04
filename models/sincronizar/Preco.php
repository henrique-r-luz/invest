<?php

namespace app\models\sincronizar;

use Yii;
use app\models\financas\Ativo;
use app\lib\behavior\AuditoriaBehavior;
use app\models\sincronizar\AtualizaAcoes;

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
            [['valor', 'data'], 'required'],
            [['valor'], 'number', 'min' => 0],
            [['ativo_id'], 'default', 'value' => null],
            [['ativo_id', 'atualiza_acoes_id'], 'integer'],
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
            'atualiza_acoes_id' => 'Atualização Id'
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

    public function getAtualizaAcoes()
    {
        return $this->hasOne(AtualizaAcoes::className(), ['id' => 'atualiza_acoes_id']);
    }
}
