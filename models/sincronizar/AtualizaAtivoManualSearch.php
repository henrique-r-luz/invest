<?php

namespace app\models\sincronizar;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\sincronizar\AtualizaAtivoManual;

/**
 * AtualizaAtivoManualSearch represents the model behind the search form of `app\models\sincronizar\AtualizaAtivoManual`.
 */
class AtualizaAtivoManualSearch extends AtualizaAtivoManual
{

    public $investidor;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['investidor', 'itens_ativo_id'], 'string']
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
        $query = AtualizaAtivoManual::find()
            ->joinWith([
                'itensAtivo.investidor',
                'itensAtivo.ativos'
            ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $dataProvider->sort->attributes['investidor'] = [
            'asc' => ['investidor.nome' => SORT_ASC],
            'desc' => ['investidor.nome' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'atualiza_ativo_manual.id' => $this->id,
            //'itens_ativo_id' => $this->itens_ativo_id,
        ]);

        $query->andFilterWhere(['ilike', 'investidor.nome', $this->investidor]);

        if (\is_numeric($this->itens_ativo_id)) {
            $query->andFilterWhere(['itens_ativo.id' => $this->itens_ativo_id]);
        } else {
            $query->andFilterWhere(['ilike', 'ativo.codigo', $this->itens_ativo_id]);
        }

        return $dataProvider;
    }
}
