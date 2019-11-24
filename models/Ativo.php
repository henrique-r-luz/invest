<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "public.ativo".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property int $quantidade
 * @property double $valor_compra
 * @property double $valor_bruto
 * @property double $valor_liquido
 * @property int $tipo_id
 * @property int $categoria_id
 */
class Ativo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'public.ativo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nome', 'codigo', 'tipo_id', 'categoria_id','ativo'], 'required'],
            [['nome', 'codigo'], 'string'],
            [['quantidade', 'tipo_id', 'categoria_id'], 'default', 'value' => null],
            [['tipo_id', 'categoria_id','acao_bolsa_id'], 'integer'],
            [['ativo'],'boolean'],
            [['valor_compra', 'valor_bruto', 'valor_liquido','quantidade'], 'number'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['tipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['tipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'codigo' => 'Codigo',
            'quantidade' => 'Quantidade',
            'valor_compra' => 'Valor Compra',
            'valor_bruto' => 'Valor Bruto',
            'valor_liquido' => 'Valor Liquido',
            'tipo_id' => 'Tipo',
            'categoria_id' => 'Categoria',
            'ativo'=>'Ativo',
            'acao_bolsa_id'=>'Empresas'
        ];
    }
    
    public static function lucroPrejuizo(){
      $valorCompra = Ativo::find()
                     ->sum(['valor_compra']);
      $valorLiquido = Ativo::find()
                     ->sum(['valor_liquido']);
      return $valorLiquido - $valorCompra;
                       
                              
    }
    
       /**
     * @return ActiveQuery
     */
    public function getTipo() {
        return $this->hasOne(Tipo::class, ['id'=>'tipo_id']);
    }
    
    /**
     * @return ActiveQuery
     */
    public function getCategoria() {
        return $this->hasOne(Categoria::class, ['id'=>'categoria_id']);
    }
    
    /**
     * @return ActiveQuery
     */
    public function getOperacao() {
        return $this->hasMany(Operacao::class, ['ativo_id'=>'id']);
    }
    
     public function getAcaoBolsa() {
        return $this->hasOne(AcaoBolsa::class, ['id'=>'acao_bolsa_id']);
    }
}
