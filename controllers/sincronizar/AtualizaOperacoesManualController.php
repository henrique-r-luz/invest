<?php

namespace app\controllers\sincronizar;

use Yii;
use Throwable;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\lib\helpers\InvestException;
use app\models\sincronizar\AtualizaOperacoesManual;
use app\models\sincronizar\AtualizaOperacoesManualSearch;
use app\models\sincronizar\services\AtualizacaoOperacoesManualServices;

/**
 * AtualizaOperacoesManualController implements the CRUD actions for AtualizaOperacoesManual model.
 */
class AtualizaOperacoesManualController extends Controller
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
     * Lists all AtualizaOperacoesManual models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AtualizaOperacoesManualSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AtualizaOperacoesManual model.
     * @param int $id ID
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
     * Creates a new AtualizaOperacoesManual model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        try {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $model = new AtualizaOperacoesManual();
            $atualizacaoOperacoesManualServices = new AtualizacaoOperacoesManualServices();
            if ($atualizacaoOperacoesManualServices->load(Yii::$app->request->post())) {
                $atualizacaoOperacoesManualServices->salvar();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $atualizacaoOperacoesManualServices->getId()]);
            }
        } catch (InvestException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Throwable) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Um erro inesperado ocorreu. ');
        } finally {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AtualizaOperacoesManual model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        try {
            $connection = Yii::$app->db;
            $transaction = $connection->beginTransaction();
            $model = $this->findModel($id);
            $atualizacaoOperacoesManualServices = new AtualizacaoOperacoesManualServices($model);
            if ($atualizacaoOperacoesManualServices->load(Yii::$app->request->post())) {
                $atualizacaoOperacoesManualServices->salvar();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $atualizacaoOperacoesManualServices->getId()]);
            }
        } catch (InvestException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Throwable) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Um erro inesperado ocorreu. ');
        } finally {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AtualizaOperacoesManual model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AtualizaOperacoesManual model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return AtualizaOperacoesManual the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AtualizaOperacoesManual::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
