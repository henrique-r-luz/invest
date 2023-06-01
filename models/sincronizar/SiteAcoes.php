<?php

namespace app\models\sincronizar;

use Yii;

use yii\db\ActiveRecord;
use app\models\financas\Ativo;
use app\lib\behavior\AuditoriaBehavior;


/**
 *
 * @property int $ativo_id
 * @property string $url
 *
 * @property Ativo $ativo
 */
class SiteAcoes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'site_acoes';
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


    public static function getUrl()
    {
        return SiteAcoes::find()
            ->select(['ativo_id', 'url'])
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
