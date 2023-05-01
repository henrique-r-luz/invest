<?php

namespace app\models\ir\bensDireitos;

use yii\base\Model;

class FormBensDireitos extends Model
{

    public ?int $ano = null;
    public ?int $investidor_id = null;

    public function rules()
    {
        return [
            [['ano', 'investidor_id'], 'required'],
            [['ano', 'investidor_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ano' => 'Ano',
            'investidor_id' => 'Investidor'
        ];
    }

    public function anoAterior()
    {
        return 'Ano ' . ($this->ano - 1);
    }

    public function anoAtual()
    {
        return 'Ano ' . ($this->ano);
    }
}
