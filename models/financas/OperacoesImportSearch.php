<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\OperacoesImport;


/**
 * OperacoesImportSearch represents the model behind the search form of `app\models\OperacoesImport`.
 */
class OperacoesImportSearch extends OperacoesImport
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'investidor_id'], 'integer'],
            [['arquivo', 'tipo_arquivo', 'lista_operacoes_criadas_json'], 'safe'],
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
        $query = OperacoesImport::find()->orderBy(['data'=>SORT_DESC]);

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
            'investidor_id' => $this->investidor_id,
        ]);

        $query->andFilterWhere(['ilike', 'arquivo', $this->arquivo])
            ->andFilterWhere(['ilike', 'tipo_arquivo', $this->tipo_arquivo])
            ->andFilterWhere(['ilike', 'lista_operacoes_criadas_json', $this->lista_operacoes_criadas_json]);

        return $dataProvider;
    }
}
