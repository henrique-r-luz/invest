<?php

namespace app\models\sincronizar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\sincronizar\Preco;

/**
 * PrecoSearch represents the model behind the search form of `app\models\sincronizar\Preco`.
 */
class PrecoSearch extends Preco
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ativo_id'], 'integer'],
            [['valor'], 'number'],
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
        $query = Preco::find()
            ->joinWith(['ativo']);

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
            'ativo_id' => $this->ativo_id,
        ]);

        return $dataProvider;
    }
}
