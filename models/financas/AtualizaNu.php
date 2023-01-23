<?php

namespace app\models\financas;

use Yii;
use app\lib\behavior\AuditoriaBehavior;
use app\models\financas\OperacoesImport;

/**
 * This is the model class for table "atualiza_nu".
 *
 * @property float $valor_antigo
 * @property int $operacoes_import_id
 *
 */
class AtualizaNu extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atualiza_nu';
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
            [['valor_bruto_antigo', 'valor_liquido_antigo', 'operacoes_import_id'], 'required'],
            [['valor_bruto_antigo', 'valor_liquido_antigo'], 'number'],
            [['operacoes_import_id'], 'default', 'value' => null],
            [['operacoes_import_id'], 'integer'],
            // [['operacoes_import_id'], 'unique'],
            [['operacoes_import_id'], 'exist', 'skipOnError' => true, 'targetClass' => OperacoesImport::className(), 'targetAttribute' => ['operacoes_import_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'valor_bruto_antigo' => 'Valor bruto Antigo',
            'valor_liquido_antigo' => 'Valor liquido Antigo',
            'operacoes_import_id' => 'Operacao Import ID',
        ];
    }

    /**
     * Gets query for [[ItensAtivoImport]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOperacoesImport()
    {
        return $this->hasOne(OperacoesImport::className(), ['id' => 'operacoes_import_id']);
    }
}
