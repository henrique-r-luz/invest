<?php

namespace app\models\sincronizar;

use yii\base\Model;
use yii\db\Expression;
use yii\data\ActiveDataProvider;
use app\models\sincronizar\XpathBot;

/**
 * XpthBotSearch represents the model behind the search form of `app\models\sincronizar\XpathBot`.
 */
class XpthBotSearch extends XpathBot
{

    public $ativo;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'site_acao_id'], 'integer'],
            [['data', 'xpath'], 'safe'],
            [['ativo'], 'string']
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
        $query = self::find()
            ->joinWith(['siteAcoes.ativo'])
            ->select([
                'xpath_bot.id',
                'site_acao_id',
                new Expression("ativo.id||' - '||ativo.codigo as ativo"),
                'data',
                'xpath'
            ]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'data' => SORT_DESC,
                ]
            ],
        ]);

        $dataProvider->sort->attributes['ativo'] = [
            'asc' => ['ativo.codigo' => SORT_ASC],
            'desc' => ['ativo.codigo' => SORT_DESC],
        ];



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'xpath_bot.id' => $this->id,
            //'ativo_id' => $this->site_acao_id,
            'data' => $this->data,
        ]);

        $query->andFilterWhere(['ilike', 'xpath', $this->xpath]);
        $query->andFilterWhere(['ilike', 'ativo.codigo', $this->ativo]);

        return $dataProvider;
    }
}
