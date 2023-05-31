<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\Ativo;

/**
 * AtivoSearch represents the model behind the search form of `app\models\financas\Ativo`.
 */
class AtivoSearch extends Ativo
{
    public $tipo;
    public $categoria;
    public $calculo_ativo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'codigo', 'tipo', 'categoria', 'pais', 'calculo_ativo'], 'safe'],
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
        $query = Ativo::find()
            ->joinWith(['classesOperacoes']);


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->sort->attributes['calculo_ativo'] = [
            'asc'  => ['classes_operacoes.nome' => SORT_ASC],
            'desc' => ['classes_operacoes.nome' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'ativo.id' => $this->id,
            'tipo' => $this->tipo,
            'categoria' => $this->categoria,
            'pais' => $this->pais,
        ]);

        $query->andFilterWhere(['ilike', 'ativo.nome', $this->nome])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo])
            ->andFilterWhere(['ilike', 'classes_operacoes.nome', $this->calculo_ativo]);

        return $dataProvider;
    }
}
