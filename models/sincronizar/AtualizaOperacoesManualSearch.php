<?php

namespace app\models\sincronizar;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use app\models\sincronizar\AtualizaOperacoesManual;

/**
 * AtualizaOperacoesManualSearch represents the model behind the search form of `app\models\sincronizar\AtualizaOperacoesManual`.
 */
class AtualizaOperacoesManualSearch extends AtualizaOperacoesManual
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'atualiza_ativo_manual_id'], 'integer'],
            [['valor_bruto', 'valor_liquido'], 'number'],
            [['data'], 'safe'],
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
        $query = AtualizaOperacoesManual::find();

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
            'valor_bruto' => $this->valor_bruto,
            'valor_liquido' => $this->valor_liquido,
            'atualiza_ativo_manual_id' => $this->atualiza_ativo_manual_id,
            'data' => $this->data,
        ]);

        return $dataProvider;
    }


    public static function lista()
    {
        return  ArrayHelper::map(
            AtualizaAtivoManual::find()
                ->innerJoinWith([
                    'itensAtivo.ativos',
                    'itensAtivo.investidor'
                ])
                ->all(),
            'id',
            function ($model) {
                return $model->itensAtivo->ativos->codigo . ' | ' . $model->itensAtivo->investidor->nome;
            }
        );
    }
}
