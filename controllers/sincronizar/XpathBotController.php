<?php

namespace app\controllers\sincronizar;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\lib\helpers\InvestException;
use app\models\sincronizar\XpathBot;
use app\models\sincronizar\XpathBotForm;
use app\models\sincronizar\XpthBotSearch;
use app\models\sincronizar\services\XpathBotServices;

/**
 * XpathBotController implements the CRUD actions for XpathBot model.
 */
class XpathBotController extends Controller
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
     * Lists all XpathBot models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new XpthBotSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single XpathBot model.
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
     * Creates a new XpathBot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $modelForm = new XpathBotForm();
        $xpathBotServices = new XpathBotServices($modelForm);

        if (Yii::$app->request->isPost) {
            $xpathBotServices->load(Yii::$app->request->post());
            try {
                $xpathBotServices->save();
                Yii::$app->session->setFlash('success', 'Registros salvos com sucesso!');
                return $this->redirect(['index']);
            } catch (InvestException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }

        return $this->render('create', [
            'model' => $modelForm,
        ]);
    }

    /**
     * Updates an existing XpathBot model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelForm = new XpathBotForm();
        $xpathBotServices = new XpathBotServices($modelForm);
        $xpathBotServices->setModel($id);
        if (Yii::$app->request->isPost) {
            $xpathBotServices->load(Yii::$app->request->post());
            try {
                $xpathBotServices->update();
                Yii::$app->session->setFlash('success', 'Registros salvos com sucesso!');
                return $this->redirect(['index']);
            } catch (InvestException $e) {
                Yii::$app->session->setFlash('danger', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $modelForm,
            'id' => $id
        ]);

        /* $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);*/
    }

    /**
     * Deletes an existing XpathBot model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!$this->findModel($id)->delete()) {
            $response = [
                'resp' => false,
                'msg' => 'Ocorreu um erro ao remover o Registro. '
            ];
        }

        $response = [
            'resp' => true,
            'msg' => true
        ];

        return $response;
    }

    /**
     * Finds the XpathBot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return XpathBot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = XpathBot::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
