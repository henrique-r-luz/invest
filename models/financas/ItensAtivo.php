<?php

namespace app\models\financas;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\financas\Ativo;
use app\models\financas\Investidor;
use app\lib\behavior\AuditoriaBehavior;

/**
 * This is the model class for table "itens_ativo".
 *
 * @property int $id
 * @property int $ativo_id
 * @property int $investidor_id
 * @property float|null $quantidade
 * @property float|null $valor_compra
 * @property float|null $valor_liquido
 * @property float|null $valor_bruto
 *
 * @property Ativo $ativo
 * @property Investidor $investidor
 */
class ItensAtivo extends \yii\db\ActiveRecord
{

    public $preco_valor;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'itens_ativo';
    }

    public function behaviors()
    {
        return [
            AuditoriaBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     * Os valores são registrados na moeda de origem do ativo
     */
    public function rules()
    {
        return [
            [['ativo_id', 'investidor_id', 'ativo'], 'required'],
            [['ativo_id', 'investidor_id'], 'default', 'value' => null],
            [['ativo_id', 'investidor_id'], 'integer'],
            [['ativo'], 'boolean'],
            [['valor_liquido', 'valor_bruto', 'valor_compra'], 'number'],
            [['quantidade', 'preco_valor'], 'number', 'min' => 0],
            [['quantidade'], 'validaQuantidade'],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
            [['investidor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Investidor::className(), 'targetAttribute' => ['investidor_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ativo_id' => 'Ativo ID',
            'investidor_id' => 'Investidor ID',
            'quantidade' => 'Quantidade',
            'valor_compra' => 'Valor Compra',
            'valor_liquido' => 'Valor Liquido',
            'valor_bruto' => 'Valor Bruto',
            'ativo' => 'Ativo'
        ];
    }

    /**
     * Gets query for [[Ativo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAtivos()
    {
        return $this->hasOne(Ativo::className(), ['id' => 'ativo_id']);
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


    public function validaQuantidade()
    {
        if ($this->quantidade < 0) {
            $this->addError('quantidade', 'A quantidade do item ativo deve ser positiva.');
        }
    }

    public static function lista()
    {
        return  ArrayHelper::map(
            self::find()
                ->joinWith(['ativos', 'investidor'])
                ->where(['ativo' => true])->all(),
            'id',
            function ($model) {
                return $model->id . ' - ' . $model->ativos->codigo . ' | ' . $model->investidor->nome . ' | ' . $model->ativos->pais;
            }
        );
    }
}
