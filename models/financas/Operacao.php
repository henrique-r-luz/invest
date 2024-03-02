<?php

namespace app\models\financas;

use Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\lib\behavior\AuditoriaBehavior;

/**
 * This is the model class for table "public.operacao".
 *
 * @property int $id
 * @property string $tipo
 * @property int $quantidade
 * @property double $valor
 * @property string $data
 * @property int $itens_ativos_id
 */
class Operacao extends ActiveRecord
{

    const VENDA = 'Venda';
    const COMPRA = 'Compra';
    const DESDOBRAMENTO_MAIS = 'DESDOBRAMENTO_MAIS'; //aumenta a quantidade de ativos
    const DESDOBRAMENTO_MENOS = 'DESDOBRAMENTO_MENOS'; //diminui a quantidade de ativos

    /**
     * retorna o tipo de operação
     * @return type
     */
    public static function tipoOperacao()
    {
        return [
            0 => self::VENDA,
            1 => self::COMPRA,
            2 => self::DESDOBRAMENTO_MAIS,
            3 => self::DESDOBRAMENTO_MENOS
        ];
    }

    public function behaviors()
    {
        return [
            AuditoriaBehavior::class,
        ];
    }

    public static function tipoOperacaoId()
    {
        return [
            self::VENDA => 0,
            self::COMPRA => 1,
            self::DESDOBRAMENTO_MAIS => 2,
            self::DESDOBRAMENTO_MENOS => 3
        ];
    }


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public.operacao';
    }

    /**
     * {@inheritdoc}
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tipo', 'quantidade', 'valor', 'data', 'itens_ativos_id'], 'required'],
            [['quantidade', 'itens_ativos_id'], 'default', 'value' => null],
            [['itens_ativos_id', 'tipo'], 'integer'],
            [['quantidade'], 'safe'],
            [['valor', 'preco_medio'], 'number', 'min' => 0],
            /*[
                ['data'], 'unique',
                'targetAttribute' => ['itens_ativos_id', 'data'],
                'comboNotUnique' => 'Já existe um registro de operação desse ativo nessa data e hora',
            ],*/
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'quantidade' => 'Quantidade',
            'valor' => 'Valor',
            'data' => 'Data',
            'itens_ativos_id' => 'Item Ativo',
            'preco_medio' => 'Preço Médio'
        ];
    }


    public function beforeSave($insert)
    {
        if ($this->tipo == 2 || $this->tipo == 3) {
            $this->valor = 0;
        }
        return  parent::beforeSave($insert);
    }

    public static function getTipoOperacao($id)
    {
        return self::tipoOperacao()[$id];
    }

    public static function getTipoOperacaoId($id)
    {
        return self::tipoOperacaoId()[$id];
    }

    /**
     * @return ActiveQuery
     */
    public function getItensAtivo()
    {
        return $this->hasOne(ItensAtivo::class, ['id' => 'itens_ativos_id']);
    }
}
