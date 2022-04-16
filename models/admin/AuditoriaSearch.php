<?php

namespace app\models\admin;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\admin\Auditoria;

/**
 * AuditoriaSearch represents the model behind the search form of `app\models\admin\Auditoria`.
 */
class AuditoriaSearch extends Auditoria
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at'], 'integer'],
            [['model', 'user_id', 'operacao', 'changes'], 'safe'],
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
        $query = Auditoria::find()
        ->joinWith(['user'])
        ->orderBy(['created_at'=>SORT_DESC]);

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
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'model', $this->model])
            ->andFilterWhere(['ilike', 'operacao', $this->operacao])
            ->andFilterWhere(['ilike', 'user.username', $this->user_id]);

        return $dataProvider;
    }
}
