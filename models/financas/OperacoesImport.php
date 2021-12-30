<?php

namespace app\models\financas;

use Yii;
use app\models\financas\Investidor;

/**
 * This is the model class for table "operacoes_import".
 *
 * @property int $id
 * @property int $investidor_id
 * @property string|null $arquivo
 * @property string|null $tipo_arquivo
 * @property string|null $lista_operacoes_criadas_json
 *
 * @property Investidor $investidor
 */
class OperacoesImport extends \yii\db\ActiveRecord
{

    private $diretorio = 'arquivos';
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operacoes_import';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['investidor_id'], 'required'],
            [['investidor_id'], 'default', 'value' => null],
            [['investidor_id'], 'integer'],
            [['arquivo'],'file','skipOnEmpty' => false],
            [['tipo_arquivo', 'lista_operacoes_criadas_json'], 'string'],
            [['investidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Investidor::className(), 'targetAttribute' => ['investidor_id' => 'id']],
            [['arquivo'],'validaType'],   
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'investidor_id' => 'Investidor',
            'arquivo' => 'Arquivo',
            'tipo_arquivo' => 'Tipo Arquivo',
            'lista_operacoes_criadas_json' => 'Lista Operacoes Criadas Json',
        ];
    }

    /**
     * Gets query for [[Investidor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvestidor()
    {
        return $this->hasOne(Investidor::className(), ['id' => 'investidor_id']);
    }


    public function validaType(){
        if($this->arquivo->type!='text/csv'){
           $this->addError('arquivo','Tipo Errado');
        }
    }


    public function saveUpload(){
        if ($this->validate()) {
            $this->arquivo->saveAs(Yii::getAlias('@arquivos').'/' . $this->arquivo->baseName . '.' . $this->arquivo->extension);
            $this->save();
            return true;
        } else {
            return false;
        }  
    }
}
