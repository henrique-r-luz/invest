<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\Operacao;

/**
 * OperacaoSearch represents the model behind the search form of `app\models\Operacao`.
 */
class OperacaoSearch extends Operacao
{
    
    public $ativo_codigo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ativo_id'], 'integer'],
            [['tipo', 'data','ativo_codigo'], 'safe'],
            [['valor','quantidade'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Operacao::find()
                ->innerJoin('ativo','ativo.id = operacao.ativo_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
             'pagination' => [
                'pageSize' => 10,
            ],
             'sort'=> ['defaultOrder' => ['data'=>SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'operacao.quantidade' => $this->quantidade,
            'valor' => $this->valor,
            'data' => $this->data,
            'operacao.tipo'=>$this->tipo
            //'ativo_id' => $this->ativo_id,
        ]);

        //$query->andFilterWhere(['ilike', 'tipo', $this->tipo]);
        
         $query->andFilterWhere(['ilike', 'ativo.codigo', $this->ativo_codigo]);

        return $dataProvider;
    }
    
    public function searchContAporte($model){
       
       $query = Operacao::find()
                ->select(['ativo.codigo as codigo','ativo.nome as nome','sum(operacao.valor) as total','sum(operacao.quantidade) as quantidade'])
                ->innerJoin('ativo','ativo.id = operacao.ativo_id')
                ->where(['between', 'data',$model->dataInicio, $model->dataFim])
               ->andWhere(['operacao.tipo'=>1])//operação de compra
               ->andWhere(['ativo.tipo_id'=>7])
               ->groupBy(['ativo.codigo','ativo.nome'])
               ->orderBy(['sum(operacao.valor)'=>SORT_DESC])->asArray()->all();
       
       
        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
             'pagination' => false,
        ]);
        return $dataProvider;
        #echo $query->createCommand()->getSql();
        #exit();
               
    }
}