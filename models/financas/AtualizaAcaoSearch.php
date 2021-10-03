<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\AtualizaAcao;

/**
 * AtualizaAcaoSearch represents the model behind the search form of `app\models\financas\AtualizaAcao`.
 */
class AtualizaAcaoSearch extends AtualizaAcao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ativo_id'], 'safe'],
            [['url'], 'safe'],
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
        $query = AtualizaAcao::find()
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
       /* $query->andFilterWhere([
            'ativo_id' => $this->ativo_id,
        ]);*/

        $query->andFilterWhere(['ilike', 'url', $this->url]);
        $query->andFilterWhere(['ilike', 'ativo.codigo', $this->ativo_id]);

        return $dataProvider;
    }
}
