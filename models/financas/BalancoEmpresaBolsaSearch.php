<?php

namespace app\models\financas;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\financas\BalancoEmpresaBolsa;

/**
 * BalancoEmpresaBolsaSearch represents the model behind the search form of `app\models\BalancoEmpresaBolsa`.
 */
class BalancoEmpresaBolsaSearch extends BalancoEmpresaBolsa {

    private $query;

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'margem_ebit', 'margem_liquida', 'roe', 'divida_bruta_patrimonio', 'fcl_capex', 'payout'], 'integer'],
            [['data', 'codigo', 'trimestre'], 'safe'],
            [['patrimonio_liquido', 'receita_liquida', 'ebitda', 'da', 'ebit', 'resultado_financeiro', 'imposto', 'lucro_liquido', 'caixa', 'divida_bruta', 'divida_liquida', 'divida_liquida_ebitda', 'fco', 'capex', 'fcf', 'fcl', 'proventos', 'pdd', 'pdd_lucro_liquido', 'indice_basileia'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios() {
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
    public function search($params) {
        $this->query = BalancoEmpresaBolsa::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $this->query->andFilterWhere([
            'id' => $this->id,
            'patrimonio_liquido' => $this->patrimonio_liquido,
            'receita_liquida' => $this->receita_liquida,
            'ebitda' => $this->ebitda,
            'da' => $this->da,
            'ebit' => $this->ebit,
            'margem_ebit' => $this->margem_ebit,
            'resultado_financeiro' => $this->resultado_financeiro,
            'imposto' => $this->imposto,
            'lucro_liquido' => $this->lucro_liquido,
            'margem_liquida' => $this->margem_liquida,
            'roe' => $this->roe,
            'caixa' => $this->caixa,
            'divida_bruta' => $this->divida_bruta,
            'divida_liquida' => $this->divida_liquida,
            'divida_bruta_patrimonio' => $this->divida_bruta_patrimonio,
            'divida_liquida_ebitda' => $this->divida_liquida_ebitda,
            'fco' => $this->fco,
            'capex' => $this->capex,
            'fcf' => $this->fcf,
            'fcl' => $this->fcl,
            'fcl_capex' => $this->fcl_capex,
            'proventos' => $this->proventos,
            'payout' => $this->payout,
            'pdd' => $this->pdd,
            'pdd_lucro_liquido' => $this->pdd_lucro_liquido,
            'indice_basileia' => $this->indice_basileia,
            'trimestre' => $this->trimestre,
        ]);

        $this->query->andFilterWhere(['ilike', 'data', $this->data])
                ->andFilterWhere(['ilike', 'codigo', $this->codigo])
                ->orderBy(['data' => SORT_ASC]);



        return $dataProvider;
    }

    public function criaDadosGrafico() {
        $queryGrafico = clone $this->query;
        $dados = $queryGrafico->asArray()->all();
        //print_r($dados);
        $dadosGrafico = [];
        //  $first_names = array_column($records, 'first_name');
        foreach ($dados[0] as $key => $atributo) {
            if ($key == 'id' || $key == 'trimestre' || $key == 'da' || $key == 'imposto' || $key == 'codigo') {
                continue;
            }
            //if ($key == 'patrimonio_liquido' || $key=='data') {
                $valores = array_map('floatval', array_column($dados, $key));
                array_push($dadosGrafico, ['name' => $key, 'data' =>$valores]);
            //}
            //array_push($dadosGrafico,['name'=>$key,'data'=>[1,2,3,4,5,6]]);
        }
        return $dadosGrafico;
    }

}
