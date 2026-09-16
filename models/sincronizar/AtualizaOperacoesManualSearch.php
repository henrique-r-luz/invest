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
    public $ativo_nome;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'atualiza_ativo_manual_id'], 'integer'],
            [['valor_bruto', 'valor_liquido'], 'number'],
            [['data', 'ativo_nome'], 'safe'],
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
        $query = AtualizaOperacoesManual::find()
            ->select(['atualiza_operacoes_manual.*'])
            ->joinWith(['atualizaAtivoManual.itensAtivo.ativos']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => ['data' => SORT_DESC],
                'attributes' => [
                    'id',
                    'valor_bruto',
                    'valor_liquido',
                    'atualiza_ativo_manual_id',
                    'data',
                    'ativo_nome' => [
                        'asc' => ['ativo.nome' => SORT_ASC],
                        'desc' => ['ativo.nome' => SORT_DESC],
                    ],
                ],
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
            'atualiza_operacoes_manual.id' => $this->id,
            'atualiza_operacoes_manual.valor_bruto' => $this->valor_bruto,
            'atualiza_operacoes_manual.valor_liquido' => $this->valor_liquido,
            'atualiza_operacoes_manual.atualiza_ativo_manual_id' => $this->atualiza_ativo_manual_id,
            'atualiza_operacoes_manual.data' => $this->data,
        ]);

        $query->andFilterWhere(['ilike', 'ativo.nome', $this->ativo_nome]);

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
