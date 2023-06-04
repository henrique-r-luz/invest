<?php

namespace app\models\sincronizar;

use app\lib\dicionario\StatusAtualizacaoAcoes;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "atualiza_acoes".
 *
 * @property int $id
 * @property string $data
 * @property string|null $ativo_atualizado
 * @property string $status
 */
class AtualizaAcoes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'atualiza_acoes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'status'], 'required'],
            [['data', 'ativo_atualizado'], 'safe'],
            [['status'], 'string'],
            [['status'], 'validaStatus'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data' => 'Data',
            'ativo_atualizado' => 'Ativo Atulizado',
            'status' => 'Status',
        ];
    }


    public function validaStatus()
    {
        if ($this->isNewRecord && self::find()->where(['status' => StatusAtualizacaoAcoes::PROCESSANDO])->exists()) {
            $this->addError('status', 'O sistema ainda está atualizando os preços');
        }
    }

    /**
     * Analisa os ativo processados
     * para apresentar na view
     *
     * @param [type] $model
     * @param [type] $status
     * @return void
     * @author Henrique Luz
     */
    public function formataAtivoAtualizados($status)
    {
        $ativoCodigo = '';
        if (empty($this->ativo_atualizado)) {
            return $ativoCodigo;
        }
        foreach ($this->ativo_atualizado as $id => $ativos) {
            if ($ativos['status'] == $status) {
                $ativoCodigo .= $ativos['codigo'] . ', ';
            }
        }
        return $ativoCodigo;
    }
}
