<?php

namespace app\controllers\financas;

use Yii;
use Throwable;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\financas\Operacao;
use yii\web\NotFoundHttpException;
use app\lib\helpers\InvestException;
use app\models\financas\OperacaoSearch;
use app\lib\config\atualizaAtivos\TiposOperacoes;
use app\models\financas\service\operacoesAtivos\OperacaoService;

/**
 * OperacaoController implements the CRUD actions for Operacao model.
 */
class OperacaoController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
     * Lists all Operacao models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new OperacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Operacao model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Operacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $model = new Operacao();
        $operacaoService = new OperacaoService($model, TiposOperacoes::INSERIR);
        try {
            if ($operacaoService->load(Yii::$app->request->post())) {
                $operacaoService->acaoSalvaOperacao();
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Dados salvos com sucesso!');
                return $this->redirect(['view', 'id' => $operacaoService->getOpereacao()->id]);
            }
        } catch (InvestException $ex) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Erro ao salvar Operação!</br>' . $ex->getMessage());
        } catch (Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado');
        } finally {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Operacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $model = $this->findModel($id);
        $operacaoService = new OperacaoService($model, TiposOperacoes::UPDATE);
        try {

            if ($operacaoService->load(Yii::$app->request->post())) {
                $operacaoService->acaoSalvaOperacao();
                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Dados salvos com sucesso!');
                return $this->redirect(['view', 'id' => $operacaoService->getOpereacao()->id]);
            }
        } catch (InvestException $ex) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Erro ao salvar Operação!</br>' . $ex->getMessage());
        } catch (Throwable $e) {
            $transaction->rollBack();

            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado');
        } finally {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Operacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $connection = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        $model = $this->findModel($id);
        $operacaoService = new OperacaoService($model, TiposOperacoes::DELETE);
        try {
            $operacaoService->acaoDeletaOperacao();
            $transaction->commit();
            $response = [
                'resp' => true,
                'msg' => true
            ];
        } catch (InvestException $ex) {
            $transaction->rollBack();
            $response = [
                'resp' => false,
                'msg' => $ex->getMessage()
            ];
        } catch (Throwable $e) {

            $transaction->rollBack();
            $response = [
                'resp' => false,
                'msg' => 'Ocorreu um erro inesperado ' . $e->getMessage()
            ];
        } finally {
            return  $response;
        }

        //return $this->redirect(['index']);
    }

    /**
     * Finds the Operacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Operacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Operacao::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
