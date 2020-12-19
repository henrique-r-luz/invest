<?php

namespace app\models\financas;

use app\lib\CajuiHelper;
use Exception;
use Throwable;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\financas\Ativo;

/**
 * This is the model class for table "public.operacao".
 *
 * @property int $id
 * @property string $tipo
 * @property int $quantidade
 * @property double $valor
 * @property string $data
 * @property int $ativo_id
 */
class Operacao extends ActiveRecord {

    const VENDA = 'Venda';
    const COMPRA = 'Compra';

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'public.operacao';
    }

    /**
     * {@inheritdoc}
     */
    public function transactions() {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['tipo', 'quantidade', 'valor', 'data', 'ativo_id'], 'required'],
            [['quantidade', 'ativo_id'], 'default', 'value' => null],
            [['ativo_id', 'tipo'], 'integer'],
            [['valor', 'quantidade'], 'number'],
            [['data'], 'unique',
                'targetAttribute' => ['ativo_id', 'data'],
                'comboNotUnique' => 'Já existe um registro de operação desse ativo nessa data e hora',
            ],
            [['ativo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ativo::className(), 'targetAttribute' => ['ativo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'tipo' => 'Tipo',
            'quantidade' => 'Quantidade',
            'valor' => 'Valor',
            'data' => 'Data',
            'ativo_id' => 'Ativo ID',
        ];
    }

    /**
     * retorna o tipo de operação
     * @return type
     */
    public static function tipoOperacao() {
        return [
            0 => self::VENDA,
            1 => self::COMPRA,
        ];
    }

    public static function getTipoOperacao($id) {
        return self::tipoOperacao()[$id];
    }

    /**
     * @return ActiveQuery
     */
    public function getAtivo() {
        return $this->hasOne(Ativo::class, ['id' => 'ativo_id']);
    }

    
  
    
    
    
    public static function valorDeCompra($ativo_id){
         return  max(0,(self::find()->where(['ativo_id' => $ativo_id])
                            ->andWhere(['tipo' => 1])//compra
                            ->sum('valor') -
                            self::find()->where(['ativo_id' => $ativo_id])
                            ->andWhere(['tipo' => 0])//venda
                            ->sum('valor')));
    }
    
    
    public function getValorCambio(){
       
        return Ativo::valorCambio($this->ativo, $this->valor);
       
    }

}
