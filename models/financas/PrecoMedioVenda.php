<?php

namespace app\models\financas;

use Yii;
use app\models\financas\Operacao;
use app\lib\behavior\AuditoriaBehavior;

/**
 * Grava o preço médio da ação antes da venda
 *
 * @property float $valor
 * @property int $operacoes_id
 *
 * @property Operacao $operacoes
 */
class PrecoMedioVenda extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'preco_medio_venda';
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
            [['valor', 'operacoes_id'], 'required'],
            [['valor'], 'number'],
            [['operacoes_id'], 'default', 'value' => null],
            [['operacoes_id'], 'integer'],
            [['operacoes_id'], 'unique'],
            [['operacoes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operacao::className(), 'targetAttribute' => ['operacoes_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'valor' => 'Valor',
            'operacoes_id' => 'Operacoes ID',
        ];
    }

    /**
     * Gets query for [[Operacoes]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperacoes()
    {
        return $this->hasOne(Operacao::className(), ['id' => 'operacoes_id']);
    }
}
