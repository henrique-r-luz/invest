<?php

namespace app\controllers;

use Yii;
use app\models\Ativo;
use app\models\AtivoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\Aporte;
use app\lib\CajuiHelper;
use \app\models\Operacao;
use yii\data\ArrayDataProvider;

/**
 * AtivoController implements the CRUD actions for Ativo model.
 */
class AporteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Ativo models.
     * @return mixed
     */
    public function actionIndex() {
        $model = new Aporte();
        $dados = [];
        if ($model->load(Yii::$app->request->post())) {

            //verificar o ativo com maior aporte nos último 3 meses
            //$ativoDiscartado = Operacao::find();

            $valorAcoes = Ativo::find()
                    ->where(['tipo_id' => 7])
                    ->sum('valor_bruto');

            $totalAtivo = Ativo::find()
                    ->sum('valor_bruto');


            if ((($valorAcoes * 100) / $totalAtivo) < 30 && $valorAcoes > 0) {
                //investir em ações
                $dados = $this->defineAporteAcoes($valorAcoes, $model);
            } else {
                $dados = ['Ativo' => 'Renda Fixa', 'Valor' => $model->valor];
            }
        }
        $provider = new ArrayDataProvider([
            'allModels' => $dados,
            'pagination' => false
                /* 'sort' => [
                  'attributes' => ['id', 'name'],
                  ], */
        ]);
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'model' => $model,
                    'provaider' => $provider,
        ]);
    }

    public function defineAporteAcoes($valorAcoes, $model) {
        $totalDistribuir = $valorAcoes + $model->valor;
        $vetAtivos = [];
        if (!empty($model->ativo)) {
            $vetAtivos = $model->ativo;
        }
        $totalAtivosAcoes = Ativo::find()
                ->where(['tipo_id' => 7])
                ->andWhere(['ativo' => true])
                //->andWhere($where)
                ->orderBy(['valor_bruto' => SORT_ASC])
                ->all();

        $quatiadeAcoes = count($totalAtivosAcoes);
        $valorIndividual = $totalDistribuir / $quatiadeAcoes;
        $dados = [];
        $contTotal = 0;
        foreach ($totalAtivosAcoes as $ativo) {
            if(in_array($ativo->id, $vetAtivos)){
                continue;
            }
            if($valorIndividual<=$ativo->valor_bruto){
                continue;
            }
            /*if (!empty($model->ativo)) {
                foreach ($model->ativo as $ativo_id) {
                    if ($ativo_id == $ativo->id) {
                        continue 2;
                    }
                }
            }*/
            $valorUnitario = $ativo->valor_bruto / $ativo->quantidade;
            $valorInserir = $valorIndividual - $ativo->valor_bruto;
            $valorRestante = ($model->valor - $contTotal);
            if ($valorInserir < $valorRestante) {
                $dados[] = ['Ativo' => $ativo->codigo, 'Valor' => $valorInserir, 'Quantidade' => intval($valorInserir / $valorUnitario)];
                $contTotal = $contTotal + $valorInserir;
            } else {
                $dados[] = ['Ativo' => $ativo->codigo, 'Valor' => $valorRestante, 'Quantidade' => intval($valorRestante / $valorUnitario)];
                $contTotal = $contTotal + $valorRestante;
                break;
            }
        }
        if (($model->valor - $contTotal) > 0) {
            //echo 'sobra'. ($model->valor - $contTotal);
            //exit();
            $sobra = ($model->valor - $contTotal);
            $valorUnitario = $totalAtivosAcoes[0]->valor_bruto / $totalAtivosAcoes[0]->quantidade;
            $dados[0]['Quantidade']+= intval($sobra / $valorUnitario);
            $dados[0]['Valor']+= $sobra ;
            // $dados[] = ['Ativo' => $totalAtivosAcoes[0]->codigo, 'Quantidade' => intval($sobra / $valorUnitario)];
        }
        return $dados;
    }

    /**
     * Finds the Ativo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ativo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Ativo::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
