<?php

namespace app\models\financas;

use app\lib\Pais;
use app\models\financas\service\sincroniza\CotacaoCambio;
use app\models\Tipo;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "public.ativo".
 *
 * @property int $id
 * @property string $nome
 * @property string $codigo
 * @property string $pais
 * @property int $quantidade
 * @property double $valor_compra
 * @property double $valor_bruto
 * @property double $valor_liquido
 * @property int $tipo_id
 * @property int $categoria_id
 */
class Ativo extends ActiveRecord {

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
            [['nome', 'codigo', 'tipo', 'categoria', 'ativo', 'pais', 'investidor_id'], 'required'],
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
            'codigo' => 'Código',
            'quantidade' => 'Quant.',
            'valor_compra' => 'Valor Compra',
            'valor_bruto' => 'Valor Bruto',
            'valor_liquido' => 'Valor Liquido',
            'tipo' => 'Tipo',
            'categoria' => 'Categoria',
            'ativo' => 'Ativo',
            'acao_bolsa_id' => 'Empresas',
            'pais' => 'País',
            'investidor_id' => 'Investidor'
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

    public function getProvento() {
        return $this->hasMany(Proventos::class, ['ativo_id' => 'id']);
    }

    public function getAcaoBolsa() {
        return $this->hasOne(AcaoBolsa::class, ['id' => 'acao_bolsa_id']);
    }

    public function getInvestidor() {
        return $this->hasOne(Investidor::class, ['id' => 'investidor_id']);
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

    public static function valorCambio($ativo, $valor) {
        $cotacao = new CotacaoCambio();
        $cambio = $cotacao->atualiza();

        if ($ativo->pais == Pais::US) {
            $moeda = str_replace(',', '.', $cambio['dollar']);
            return floatval($valor) * floatval($moeda);
        }
        return $valor;
    }

    public static function lista() {
        return ArrayHelper::map(Ativo::find()->where(['ativo' => true])->all(), 'id', 
                function($model){
                    return $model->codigo.' | '.$model->investidor->nome;
                });
        
    }

}
