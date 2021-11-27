<?php

namespace app\models\financas;

use app\models\financas\Ativo;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Query;

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
class Operacao extends ActiveRecord {

    const VENDA = 'Venda';
    const COMPRA = 'Compra';
    const DESDOBRAMENTO_MAIS = 'DESDOBRAMENTO_MAIS'; //aumenta a quantidade de ativos
    const DESDOBRAMENTO_MENOS = 'DESDOBRAMENTO_MENOS'; //diminui a quantidade de ativos

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
            [['tipo', 'quantidade', 'valor', 'data', 'itens_ativos_id'], 'required'],
            [['quantidade', 'itens_ativos_id'], 'default', 'value' => null],
            [['itens_ativos_id', 'tipo'], 'integer'],
            [['valor', 'quantidade'], 'number'],
            [['data'], 'unique',
                'targetAttribute' => ['itens_ativos_id', 'data'],
                'comboNotUnique' => 'Já existe um registro de operação desse ativo nessa data e hora',
            ],
            //[['itens_ativos_id'], 'exist', 'skipOnError' => true, 'targetClass' => ItensAtivo::className(), 'targetAttribute' => ['itens_ativos_id' => 'id']],
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
            'itens_ativos_id' => 'Ativo ID',
        ];
    }
    
    
    public function beforeSave($insert) {
        if($this->tipo==2 || $this->tipo==3){
            $this->valor = 0;
        }
       return  parent::beforeSave($insert);
    }

    /**
     * retorna o tipo de operação
     * @return type
     */
    public static function tipoOperacao() {
        return [
            0 => self::VENDA,
            1 => self::COMPRA,
            2 => self::DESDOBRAMENTO_MAIS,
            3 => self::DESDOBRAMENTO_MENOS
        ];
    }

    public static function tipoOperacaoId() {
        return [
            self::VENDA => 0,
            self::COMPRA => 1,
            self::DESDOBRAMENTO_MAIS => 2,
            self::DESDOBRAMENTO_MENOS => 3
        ];
    }

    public static function getTipoOperacao($id) {
        return self::tipoOperacao()[$id];
    }

    public static function getTipoOperacaoId($id) {
        return self::tipoOperacaoId()[$id];
    }

    /**
     * @return ActiveQuery
     */
    public function getItensAtivo() {
        return $this->hasOne(ItensAtivo::class, ['id' => 'itens_ativos_id']);
    }

    public static function valorDeCompra($itens_ativos_id) {

        return max(0, round(self::queryDadosAtivos($itens_ativos_id)[0]['valor_compra'], 2));
    }
    
    public static function valorDeCompraBancoInter($itens_ativos_id) {

        return max(0, round(self::queryDadosAtivosBancoInter($itens_ativos_id)[0]['valor_compra'], 2));
    }

    public static function  queryDadosAtivos($itens_ativos_id) {
        $venda = 0;
        $compra = 1;
        $desdobramentoMais = 2;
        $desdobramentoMenos = 3;

        $quantidade_venda = Operacao::find()
                ->select(['sum(quantidade) as quantidade_venda','sum(valor) as valor_venda'])
                ->andWhere(['itens_ativos_id' => $itens_ativos_id])
                ->andWhere(['tipo' => $venda]);

        $quantidade_compra = Operacao::find()
                ->select(['sum(quantidade) as quantidade_compra','sum(valor) as valor_compra'])
                ->andWhere(['itens_ativos_id' => $itens_ativos_id])
                ->andWhere(['tipo' => $compra]);
        
        $quantidade_desdobramento_menos = Operacao::find()
                ->select(['sum(quantidade) as quantidade_desdobramento_menos'])
                ->andWhere(['itens_ativos_id' => $itens_ativos_id])
                ->andWhere(['tipo' => $desdobramentoMenos]);
        
         $quantidade_desdobramento_mais = Operacao::find()
                ->select(['sum(quantidade) as quantidade_desdobramento_mais'])
                ->andWhere(['itens_ativos_id' => $itens_ativos_id])
                ->andWhere(['tipo' => $desdobramentoMais]);



        $query = (new Query())
                        ->select(['(coalesce(quantidade_compra,0)  '
                                . '- coalesce(quantidade_venda,0) '
                                . '- coalesce(quantidade_desdobramento_menos,0)'
                                . '+ coalesce(quantidade_desdobramento_mais,0)'
                                . ') as quantidade',
                            '(coalesce((valor_compra/(quantidade_compra '
                            . '- coalesce(quantidade_desdobramento_menos,0)'
                            . '+ coalesce(quantidade_desdobramento_mais,0)'
                            . ')),0) *  '
                           .'(coalesce(quantidade_compra,0)  '
                          . '- coalesce(quantidade_venda,0)  '
                          . '- coalesce(quantidade_desdobramento_menos,0)'
                          . '+ coalesce(quantidade_desdobramento_mais,0)'
                          . ')) as valor_compra'])
                
                        ->from(['quantidade_venda' => $quantidade_venda,
                            'quantidade_compra' => $quantidade_compra,
                            'desdobramento_menos'=>$quantidade_desdobramento_menos,
                            'desdobramento_mais'=>$quantidade_desdobramento_mais,
                           ])->all();
        
        return $query;
    }
    
    
     public static function  queryDadosAtivosBancoInter($itens_ativos_id) {
        $venda = 0;
        $compra = 1;

        $valor_venda = Operacao::find()
                ->select('sum(valor) as valor_venda')
                ->andWhere(['itens_ativos_id' => $itens_ativos_id])
                ->andWhere(['tipo' => $venda]);

        $valor_compra = Operacao::find()
                ->select('sum(valor) as valor_compra')
                ->andWhere(['itens_ativos_id' => $itens_ativos_id])
                ->andWhere(['tipo' => $compra]);


        $query = (new Query())
                        ->select(['(coalesce(valor_compra,0)  - coalesce(valor_venda,0)) as valor_compra'])
                        ->from(['quantidade_venda' => $valor_venda,
                            'quantidade_compra' => $valor_compra])->all();
        
        return $query;
    }
    

    public function getValorCambio() {
        return Ativo::valorCambio($this->itensAtivo->ativos, $this->valor);
    }

}
