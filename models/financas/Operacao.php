<?php

namespace app\models\financas;

use Exception;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\financas\Ativo;
use app\models\financas\service\operacoesAtivos\DadosOperacoesAtivos;
use app\models\financas\service\operacoesAtivos\DadosAtivosBancoInter;
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
            [['valor', 'quantidade'], 'number'],
            [
                ['data'], 'unique',
                'targetAttribute' => ['itens_ativos_id', 'data'],
                'comboNotUnique' => 'Já existe um registro de operação desse ativo nessa data e hora',
            ],
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
            'itens_ativos_id' => 'Ativo ID',
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

    public static function valorDeCompra($itens_ativos_id)
    {
        $dadosOperacoesAtivos = new DadosOperacoesAtivos();
        $dadosOperacoesAtivos->setItens_ativos_id($itens_ativos_id);
        $dados = $dadosOperacoesAtivos->geraQuery();
        if (isset($dados[0]['valor_compra'])) {
            return  $dados[0]['valor_compra'];
        }
        throw new Exception('Valor de compra não encontrato');
    }

    public static function valorDeCompraBancoInter($itens_ativos_id)
    {
        $dadosAtivosBancoInter = new DadosAtivosBancoInter();
        $dadosAtivosBancoInter->setItens_ativos_id($itens_ativos_id);
        $dados = $dadosAtivosBancoInter->geraQuery();
        if (isset($dados[0]['valor_compra'])) {
            return  $dados[0]['valor_compra'];
        }
        throw new Exception('Valor de compra não encontrato');
    }
}
