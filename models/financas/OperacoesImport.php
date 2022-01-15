<?php

namespace app\models\financas;

use app\lib\CajuiHelper;
use Yii;
use app\models\financas\Investidor;
use Exception;

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
            [['investidor_id', 'tipo_arquivo', 'arquivo'], 'required'],
            [['investidor_id'], 'default', 'value' => null],
            [['investidor_id'], 'integer'],
            [['arquivo'], 'file', 'skipOnEmpty' => false],
            [['tipo_arquivo', 'lista_operacoes_criadas_json', 'hash_nome', 'extensao'], 'string'],
            [['investidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Investidor::className(), 'targetAttribute' => ['investidor_id' => 'id']],
            [['arquivo'], 'validaTypeUpload'],
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


    /**
     * validaTypeUpload
     * valida o tipo de arquivo upload
     * @return void
     */
    public function validaTypeUpload()
    {
        if ($this->arquivo->type != 'text/csv') {
            $this->addError('arquivo', 'Tipo Errado');
        }
    }



    /**
     * @return void
     */
    public function saveUpload()
    {
        if ($this->validate()) {
            if (!$this->geraHashUpload()) {
                return false;
            }
            $this->extensao = $this->arquivo->extension;
            if (!$this->arquivo->saveAs(Yii::getAlias('@' . $this->diretorio) . '/' . $this->hash_nome . '.' . $this->arquivo->extension)) {
                $this->addError('arquivo', 'Arquivo de upload não foi gerado. ');
                return false;
            }
            if (!$this->save()) {
                $this->addError('arquivo', CajuiHelper::processaErros($this->getErrors()));
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * geraHashUpload
     * gera hash para arquivo upload
     * @return void
     */
    private function geraHashUpload()
    {
        if (file_exists($this->arquivo->tempName)) {
            $this->hash_nome =  hash_file('sha3-512', $this->arquivo->tempName);
            return true;
        } else {
            $this->addError('arquivo', 'Arquivo temporário de upload não foi gerado. ');
            return false;
        }
    }


    /**
     * @return void
     * deleta arquivo e registro
     */
    public function deleteUpload()
    {
        try {
            $arquivo = Yii::getAlias('@' . $this->diretorio) . '/' . $this->hash_nome . '.' . $this->extensao;
            unlink($arquivo);
            if (!file_exists($arquivo)) {
                $this->delete();
            }
        } catch (Exception $e) {
            $this->addError('arquivo', 'Erro ao remover registro. ');
        }
    }
}
