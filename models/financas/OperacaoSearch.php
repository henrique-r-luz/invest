<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\models\financas\Operacao;
use kartik\daterange\DateRangeBehavior;

/**
 * OperacaoSearch represents the model behind the search form of `app\models\Operacao`.
 */
class OperacaoSearch extends Operacao {

    public $ativo_codigo;
    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'ativo_id'], 'integer'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['tipo', 'data', 'ativo_codigo'], 'safe'],
            [['valor', 'quantidade'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function behaviors() {
        return [
            [
                'class' => \app\lib\DateRangeBehaviorAlterado::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Operacao::find()
                ->innerJoin('ativo', 'ativo.id = operacao.ativo_id');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => ['data' => SORT_DESC]],
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
            //'data' => $this->data,
            'operacao.tipo' => $this->tipo
                //'ativo_id' => $this->ativo_id,
        ]);
      
        if ($this->createTimeRange != null && $this->createTimeRange != '') {
           // $query->andFilterWhere(['>=', 'data', date("d/m/y H:i", $this->createTimeStart)])
           //         ->andFilterWhere(['<=', 'data', date("d/m/y H:i", $this->createTimeEnd)]);
            $query->andFilterWhere(['>=', 'data', $this->createTimeStart])
                    ->andFilterWhere(['<=', 'data', $this->createTimeEnd]);
        }


        $query->andFilterWhere(['ilike', 'ativo.codigo', $this->ativo_codigo]);


        return $dataProvider;
    }

    public function searchContAporte($model) {

        $query = Operacao::find()
                        ->select(['ativo.codigo as codigo', 'ativo.nome as nome', 'sum(operacao.valor) as total', 'sum(operacao.quantidade) as quantidade'])
                        ->innerJoin('ativo', 'ativo.id = operacao.ativo_id')
                        ->where(['between', 'data', $model->dataInicio, $model->dataFim])
                        ->andWhere(['operacao.tipo' => 1])//operação de compra
                        ->andWhere(['ativo.tipo' => \app\lib\Tipo::ACOES])
                        ->groupBy(['ativo.codigo', 'ativo.nome'])
                        ->orderBy(['sum(operacao.valor)' => SORT_DESC])->asArray()->all();


        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            'pagination' => false,
        ]);
        return $dataProvider;
        #echo $query->createCommand()->getSql();
        #exit();
    }

}
