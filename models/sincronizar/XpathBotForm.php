<?php

namespace app\models\sincronizar;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\sincronizar\XpathBot;
use app\models\sincronizar\SiteAcoes;

class XpathBotForm extends Model
{

    public $ativos;
    public $xpath;
    public $data;

    public function rules()
    {
        return [
            [['ativos', 'xpath', 'data'], 'required'],
            [['xpath'], 'string'],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => XpathBot::ID,
            'data' => XpathBot::DATA,
            'xpath' => XpathBot::XPATH,
        ];
    }


    public function ListaSiteAcoes()
    {
        $itenAcoesQuery =  SiteAcoes::find()
            ->joinWith(['ativo']);
        return   ArrayHelper::map(
            $itenAcoesQuery->all(),
            'ativo_id',
            function ($model) {
                return  $model->ativo->codigo;
            }
        );
    }
}
