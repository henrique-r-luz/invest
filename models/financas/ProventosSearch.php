<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\Proventos;

/**
 * ProventosSearch represents the model behind the search form of `app\models\financas\Proventos`.
 */
class ProventosSearch extends Proventos {

    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id'], 'integer'],
            [['data', 'ativo_id'], 'safe'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['valor'], 'number'],
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
        $query = Proventos::find()
                ->joinWith(['ativo'])
                ->orderBy(['data' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
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
            'valor' => $this->valor,
        ]);
     
        if ($this->createTimeRange != null && $this->createTimeRange != '') {
           // $query->andFilterWhere(['>=', 'data', date("d/m/y H:i", $this->createTimeStart)])
           //         ->andFilterWhere(['<=', 'data', date("d/m/y H:i", $this->createTimeEnd)]);
            $query->andFilterWhere(['>=', 'data', $this->createTimeStart])
                    ->andFilterWhere(['<=', 'data', $this->createTimeEnd]);
        }

        $query->andFilterWhere(['ilike', 'ativo.codigo', $this->ativo_id]);

        return $dataProvider;
    }

}
