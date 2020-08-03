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
class Ativo extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'public.ativo';
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
            [['nome', 'codigo', 'tipo', 'categoria', 'ativo', 'pais'], 'required'],
            [['nome', 'codigo', 'categoria', 'tipo'], 'string'],
            [['quantidade'], 'default', 'value' => null],
            [['acao_bolsa_id'], 'integer'],
            [['categoria'], 'string'],
            [['ativo'], 'boolean'],
            [['valor_compra', 'valor_bruto', 'valor_liquido', 'quantidade'], 'number'],
                // [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::className(), 'targetAttribute' => ['categoria_id' => 'id']],
                //[['tipo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tipo::className(), 'targetAttribute' => ['tipo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'nome' => 'Nome',
            'codigo' => 'Codigo',
            'quantidade' => 'Quantidade',
            'valor_compra' => 'Valor Compra',
            'valor_bruto' => 'Valor Bruto',
            'valor_liquido' => 'Valor Liquido',
            'tipo' => 'Tipo',
            'categoria' => 'Categoria',
            'ativo' => 'Ativo',
            'acao_bolsa_id' => 'Empresas',
            'pais' => 'País'
        ];
    }

    public static function lucroPrejuizo() {
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
        return $this->hasOne(Tipo::class, ['id' => 'tipo_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getOperacao() {
        return $this->hasMany(Operacao::class, ['ativo_id' => 'id']);
    }

    public function getAcaoBolsa() {
        return $this->hasOne(AcaoBolsa::class, ['id' => 'acao_bolsa_id']);
    }

    public function beforeSave($insert) {
        
        if ($this->quantidade <= 0) {
            $this->valor_compra = 0;
            $this->valor_bruto = 0;
            $this->valor_liquido = 0;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes) {
        //atualiza preço
        parent::afterSave($insert, $changedAttributes);
    }

    public static function valorCambio($ativo,$valor) {
        $sicroniza = new Sincroniza();
        $cambio = $sicroniza->cotacaoCambio();
        if ($ativo->pais == \app\lib\Pais::US) {
           return $valor* floatval($cambio['dollar']);
            //exit();
            return    $valor* floatval($cambio['dollar']);
        }
        return $valor;
    }

}
