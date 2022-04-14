<?php

namespace app\models\financas;
use app\lib\behavior\AuditoriaBehavior;

use Yii;

/**
 * This is the model class for table "atualiza_acao".
 *
 * @property int $ativo_id
 * @property string $url
 *
 * @property Ativo $ativo
 */
class AtualizaAcao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atualiza_acao';
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
            [['ativo_id', 'url'], 'required'],
            [['ativo_id'], 'default', 'value' => null],
            [['ativo_id'], 'integer'],
            [['url'], 'string'],
            [['ativo_id'], 'unique'],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ativo_id' => 'Ativo',
            'url' => 'Url',
        ];
    }
    
    
    public static function getUrl(){
       return AtualizaAcao::find()
                            ->select(['ativo_id','url'])
                            ->asArray()
                            ->all();
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
