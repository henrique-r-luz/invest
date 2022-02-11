<?php

namespace app\controllers\financas;

use Yii;
use Exception;
use yii\web\Controller;
use app\lib\CajuiHelper;
use yii\filters\VerbFilter;
use app\models\financas\Operacao;
use yii\web\NotFoundHttpException;
use app\models\financas\OperacaoSearch;
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
        $model = new Operacao();
        $operacaoService = new OperacaoService($model);
        try {
            if ($operacaoService->load(Yii::$app->request->post())) {
                if ($operacaoService->acaoSalvaOperacao()) {
                    Yii::$app->session->setFlash('success', 'Dados salvos com sucesso!');
                    return $this->redirect(['view', 'id' => $operacaoService->getOpereacao()->id]);
                }
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('danger', 'Erro ao salvar Operação!</br>' . $ex->getMessage());
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
        $model = $this->findModel($id);
        $operacaoService = new OperacaoService($model);
        try {
            if ($operacaoService->load(Yii::$app->request->post())) {
                if ($operacaoService->acaoSalvaOperacao()) {
                    Yii::$app->session->setFlash('success', 'Dados salvos com sucesso!');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('danger', 'Erro ao salvar Operação!</br>' . $ex->getMessage());
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
        $model = $this->findModel($id);
        $operacaoService = new OperacaoService($model);
        try {
            if ($operacaoService->acaoDeletaOperacao()) {
                Yii::$app->session->setFlash('success', 'Dados excluídos com sucesso!');
            }
        } catch (Exception $ex) {
            Yii::$app->session->setFlash('danger', 'Erro ao delete Operação!</br>' . $ex->getMessage());
        } finally {
            return $this->redirect(['index']);
        }
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
