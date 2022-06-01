<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\OperacoesImport;
use app\lib\behavior\DateRangeBehaviorAlterado;


/**
 * OperacoesImportSearch represents the model behind the search form of `app\models\OperacoesImport`.
 */
class OperacoesImportSearch extends OperacoesImport
{

    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'investidor_id'], 'integer'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['arquivo', 'tipo_arquivo', 'data', 'lista_operacoes_criadas_json', 'itens_ativos'], 'safe'],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => DateRangeBehaviorAlterado::className(),
                'attribute' => 'createTimeRange',
                'dateStartAttribute' => 'createTimeStart',
                'dateEndAttribute' => 'createTimeEnd',
            ]
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
        $query = OperacoesImport::find()
            ->joinWith(['itensAtivosImports.itensAtivo.ativos'])
            ->orderBy(['data' => SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $dataProvider->sort->attributes['itens_ativos'] = [
            'asc'  => ['ativo.codigo' => SORT_ASC],
            'desc' => ['ativo.codigo' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'operacoes_import.id' => $this->id,
            'investidor_id' => $this->investidor_id,
        ]);

        $query->andFilterWhere(['ilike', 'arquivo', $this->arquivo])
            ->andFilterWhere(['ilike', 'tipo_arquivo', $this->tipo_arquivo])
            ->andFilterWhere(['ilike', 'lista_operacoes_criadas_json', $this->lista_operacoes_criadas_json])
            ->andFilterWhere(['ilike', 'ativo.codigo', $this->itens_ativos]);

        if ($this->createTimeRange != null && $this->createTimeRange != '') {
            $query->andFilterWhere(['>=', 'data', $this->createTimeStart])
                ->andFilterWhere(['<=', 'data', $this->createTimeEnd]);
        }

        return $dataProvider;
    }
}
