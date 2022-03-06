<?php

namespace app\models\financas;

use Yii;

/**
 * This is the model class for table "itens_ativo_import".
 *
 * @property int $id
 * @property int $operacoes_import_id
 * @property int $itens_ativo_id
 *
 * @property ItensAtivo $itensAtivo
 * @property OperacoesImport $operacoesImport
 */
class ItensAtivoImport extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'itens_ativo_import';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['operacoes_import_id', 'itens_ativo_id'], 'required'],
            [['operacoes_import_id', 'itens_ativo_id'], 'default', 'value' => null],
            [['operacoes_import_id', 'itens_ativo_id'], 'integer'],
            [['operacoes_import_id', 'itens_ativo_id'], 'unique', 'targetAttribute' => ['operacoes_import_id', 'itens_ativo_id']],
            [['itens_ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItensAtivo::className(), 'targetAttribute' => ['itens_ativo_id' => 'id']],
            [['operacoes_import_id'], 'exist', 'skipOnError' => true, 'targetClass' => OperacoesImport::className(), 'targetAttribute' => ['operacoes_import_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'operacoes_import_id' => 'Operacoes Import ID',
            'itens_ativo_id' => 'Itens Ativo ID',
        ];
    }

    /**
     * Gets query for [[ItensAtivo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getItensAtivo()
    {
        return $this->hasOne(ItensAtivo::className(), ['id' => 'itens_ativo_id']);
    }

    /**
     * Gets query for [[OperacoesImport]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperacoesImport()
    {
        return $this->hasOne(OperacoesImport::className(), ['id' => 'operacoes_import_id']);
    }
}
