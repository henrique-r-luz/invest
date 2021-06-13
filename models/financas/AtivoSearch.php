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
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantidade'], 'integer'],
            [['nome', 'codigo','tipo','categoria','pais','investidor_id'], 'safe'],
            [['valor_compra', 'valor_bruto', 'valor_liquido'], 'number'],
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
                 ->innerJoin('investidor','investidor.id = ativo.investidor_id')
                 ->andWhere(['ativo'=>true]);
                 //->andWhere(['>','quantidade',0]);

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
            'ativo.id' => $this->id,
            'quantidade' => $this->quantidade,
            'valor_compra' => $this->valor_compra,
            'valor_bruto' => $this->valor_bruto,
            'valor_liquido' => $this->valor_liquido,
            'tipo' => $this->tipo,
            'categoria' => $this->categoria,
            'pais'=>$this->pais,
        ]);

        $query->andFilterWhere(['ilike', 'nome', $this->nome])
            ->andFilterWhere(['ilike', 'codigo', $this->codigo])
            ->andFilterWhere(['ilike', 'investidor.nome', $this->investidor_id]);
            //->andFilterWhere(['ilike', 'categoria', $this->categoria]);

        return $dataProvider;
    }
}
