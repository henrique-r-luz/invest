<?php

namespace app\models\financas;

use app\lib\CajuiHelper;
use Yii;
use app\models\financas\Investidor;
use Exception;
use app\lib\behavior\AuditoriaBehavior;

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

    public $itens_ativos;
    const DIR = 'arquivos';
    const type_pdf = 'application/pdf';
    const type_csv = 'text/plain';
    const type_uplod_file = [
        'csv' => 'text',
        'pdf' => 'pdf',
        'png' => 'image',
        'jpg' => 'image',
        'jpeg' => 'image',
        '' => 'text'
    ];
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
            [['investidor_id', 'tipo_arquivo', 'arquivo', 'data'], 'required'],
            [['investidor_id'], 'default', 'value' => null],
            [['investidor_id'], 'integer'],
            [['itens_ativos'], 'safe'],
            [['hash_nome', 'investidor_id'], 'unique', 'targetAttribute' => ['investidor_id', 'hash_nome'], 'message' => 'O arquivo já existe na base de dados. '],
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


    public function behaviors()
    {
        return [
            AuditoriaBehavior::class,
        ];
    }


    public static function all()
    {
        return [
            'pdf' => self::type_pdf,
            'csv' =>  self::type_csv
        ];
    }


    public static function get($tipo)
    {
        $all = self::all();

        if (isset($all[$tipo])) {
            return $all[$tipo];
        }

        return 'Não existe';
    }


    /**
     * Gets query for [[Investidor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvestidor()
    {
        return $this->hasOne(Investidor::class, ['id' => 'investidor_id']);
    }




    /**
     * validaTypeUpload
     * valida o tipo de arquivo upload
     * @return void
     */
    public function validaTypeUpload()
    {
        if (
            $this->arquivo->type != 'text/csv' &&
            $this->arquivo->type != 'application/pdf'
        ) {
            $this->addError('arquivo', 'Tipo de arquivo errado');
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
            if (!file_exists(Yii::getAlias('@' . self::DIR))) {
                mkdir(Yii::getAlias('@' . self::DIR));
            }
            if (!$this->arquivo->saveAs(Yii::getAlias('@' . self::DIR) . '/' . $this->hash_nome . '.' . $this->arquivo->extension)) {
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
            if ($this->removeArquivo()) {
                $this->delete();
            }
        } catch (Exception $e) {
            $this->addError('arquivo', 'Erro ao remover registro. ');
        }
    }

    public function removeArquivo()
    {
        $arquivo = Yii::getAlias('@' . self::DIR) . '/' . $this->hash_nome . '.' . $this->extensao;
        if (file_exists($arquivo)) {
            unlink($arquivo);
        }
        return (!file_exists($arquivo));
    }
}
