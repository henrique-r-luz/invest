<?php

namespace app\models\sincronizar;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AtualizaAcaoSearch represents the model behind the search form of `app\models\financas\AtualizaAcao`.
 */
class SiteAcoesSearch extends SiteAcoes
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ativo_id'], 'safe'],
            [['url'], 'string'],
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
        $query = SiteAcoes::find()
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

        $query->andFilterWhere(['ilike', 'url', $this->url]);
        $query->andFilterWhere(['ilike', 'ativo.codigo', $this->ativo_id]);

        return $dataProvider;
    }
}
