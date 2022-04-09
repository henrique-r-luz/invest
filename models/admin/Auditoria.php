<?php


namespace app\models\admin;

use Yii;
use yii\db\ActiveRecord;

/**
 *
 * @property integer $id
 * @property string  $model
 * @property string  $model_id
 * @property string  $operacao
 * @property string  $changes
 * @property integer $created_by
 * @property integer $created_at
 *
 * @property User $createdBy
 *
 * @author Christopher Mota
 * @since  1.1.0
 */
class Auditoria extends ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auditoria';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'operacao', 'user_id', 'created_at'], 'required'],
            [['model', 'operacao'], 'string'],
            ['changes', 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['created_by' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'model'      => 'Model',
            'operacao'   => 'Operacao',
            'changes'    => 'Changes',
            'user_id'    => 'User',
            'created_at' => 'Created At',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeComments()
    {
        return [
            'id'         => 'Identificador do registro de alteração numa tabela.',
            'model'      => 'Classe modelo que representa a tabela alterada.',
            'operacao'   => 'Operação que alterou a tabela: INSERT, DELETE, TRUNCATE.',
            'changes'    => 'Registra diferença após alteração da tabela.',
            'user_id' => 'Identificador do usuário que executou a operação',
            'created_at' => 'Identificador do registro de alteração numa tabela',
        ];
    }

   
}
