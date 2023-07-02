<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\AcaoBolsa;

/**
 * AcaoBolsaSearch represents the model behind the search form of `app\models\AcaoBolsa`.
 */
class AcaoBolsaSearch extends AcaoBolsa
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'codigo', 'setor', 'cnpj'], 'safe'],
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
        $query = AcaoBolsa::find();

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
        ]);

        $query->andFilterWhere(['ilike', 'nome', $this->nome])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo])
            ->andFilterWhere(['ilike', 'setor', $this->setor]);

        return $dataProvider;
    }
}
