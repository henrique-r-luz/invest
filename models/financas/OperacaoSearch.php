<?php

namespace app\models\financas;

use yii\base\Model;
use app\lib\dicionario\Tipo;
use yii\data\ArrayDataProvider;
use yii\data\ActiveDataProvider;
use app\models\financas\Operacao;
use app\lib\behavior\DateRangeBehaviorAlterado;

/**
 * OperacaoSearch represents the model behind the search form of `app\models\Operacao`.
 */
class OperacaoSearch extends Operacao
{

    public $ativo_codigo;
    public $createTimeRange;
    public $createTimeStart;
    public $createTimeEnd;
    public $investidor;
    public $pais;
    public $tipo_ativo;
    public $ativo_id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'itens_ativos_id', 'ativo_id'], 'integer'],
            [['createTimeRange'], 'match', 'pattern' => '/^.+\s\-\s.+$/'],
            [['tipo', 'data', 'ativo_codigo', 'itens_ativos_id', 'investidor'], 'safe'],
            [['pais', 'tipo_ativo'], 'string'],
            [['valor', 'quantidade'], 'number'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find()
            ->select([
                'operacao.id',
                'ativo.codigo as ativo_codigo',
                'ativo.id as ativo_id',
                'operacao.tipo',
                'operacao.quantidade',
                'operacao.valor',
                'operacao.data',
                'investidor.nome as investidor',
                'ativo.pais',
                'ativo.tipo as tipo_ativo'
            ])
            ->joinWith(['itensAtivo.investidor', 'itensAtivo.ativos']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => ['defaultOrder' => ['data' => SORT_DESC]],
        ]);

        $dataProvider->sort->attributes['ativo_codigo'] = [
            'asc' => ['ativo.codigo' => SORT_ASC],
            'desc' => ['ativo.codigo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['investidor'] = [
            'asc' => ['investidor.nome' => SORT_ASC],
            'desc' => ['investidor.nome' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['tipo_ativo'] = [
            'asc' => ['ativo.tipo' => SORT_ASC],
            'desc' => ['ativo.tipo' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['pais'] = [
            'asc' => ['ativo.pais' => SORT_ASC],
            'desc' => ['ativo.pais' => SORT_DESC],
        ];



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'operacao.id' => $this->id,
            'operacao.quantidade' => $this->quantidade,
            'valor' => $this->valor,
            'operacao.tipo' => $this->tipo,
            'ativo.tipo' => $this->tipo_ativo,
            'ativo.pais' => $this->pais
        ]);

        if ($this->createTimeRange != null && $this->createTimeRange != '') {
            $query->andFilterWhere(['>=', 'data', $this->createTimeStart])
                ->andFilterWhere(['<=', 'data', $this->createTimeEnd]);
        }


        $query->andFilterWhere(['ilike', 'investidor.nome', $this->investidor]);

        $query = FiltrosGrid::pesquisaAtivo($query, $this->ativo_codigo);


        return $dataProvider;
    }


    public function searchContAporte($model)
    {

        $query = Operacao::find()
            ->select(['ativo.codigo as codigo', 'ativo.nome as nome', 'sum(operacao.valor) as total', 'sum(operacao.quantidade) as quantidade'])
            ->innerjoin('itens_ativo', 'itens_ativo.id = operacao.itens_ativo')
            ->innerJoin('ativo', 'ativo.id = itens_ativo.ativo_id')
            ->where(['between', 'data', $model->dataInicio, $model->dataFim])
            ->andWhere(['operacao.tipo' => 1]) //operação de compra
            ->andWhere(['ativo.tipo' => Tipo::ACOES])
            ->groupBy(['ativo.codigo', 'ativo.nome'])
            ->orderBy(['sum(operacao.valor)' => SORT_DESC])->asArray()->all();


        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            'pagination' => false,
        ]);
        return $dataProvider;
    }
}
