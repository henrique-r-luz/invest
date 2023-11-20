<?php

namespace app\models\sincronizar;

use Yii;

/**
 * This is the model class for table "xpath_bot".
 *
 * @property int $id
 * @property int $site_acao_id
 * @property string|null $data
 * @property string $xpath
 *
 * @property Ativo $ativo
 */
class XpathBot extends \yii\db\ActiveRecord
{


    const ID = 'ID';
    const ATIVO = 'Ativos';
    const XPATH = 'Xpath';
    const DATA = 'Data';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'xpath_bot';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['site_acao_id', 'xpath', 'data'], 'required'],
            [['site_acao_id'], 'default', 'value' => null],
            [['site_acao_id'], 'integer'],
            [['xpath'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => self::ID,
            'site_acao_id' => self::ATIVO,
            'data' => 'Data',
            'xpath' => self::XPATH,
        ];
    }

    /**
     * Gets query for [[Ativo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSiteAcoes()
    {
        return $this->hasOne(SiteAcoes::class, ['ativo_id' => 'site_acao_id']);
    }
}
