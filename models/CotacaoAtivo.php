<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cotacao_ativo".
 *
 * @property int $id
 * @property int|null $ativo_id
 * @property float|null $valor
 * @property string|null $nome
 *
 * @property Ativo $ativo
 */
class CotacaoAtivo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cotacao_ativo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['valor'], 'required'],
            [['ativo_id'], 'default', 'value' => null],
            [['ativo_id'], 'integer'],
            [['valor'], 'number'],
            [['nome'], 'string'],
            [['valor'],'verificaNomeAtivo'],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ativo_id' => 'Ativo',
            'valor' => 'Valor',
            'nome' => 'Nome',
        ];
    }
    
    
    public function verificaNomeAtivo(){
     
        if(empty($this->nome) && empty($this->ativo_id)){
            $this->addError('ativo_id','Você tem que definir um Nome ou ativo!');
            return false;
        }
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
