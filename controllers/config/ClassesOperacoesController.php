<?php

namespace app\controllers\config;

use Yii;
use yii\web\Response;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\lib\helpers\InvestException;
use app\models\config\ClassesOperacoes;
use app\models\config\ClassesOperacoesSearch;

/**
 * ClassesOperacoesController implements the CRUD actions for ClassesOperacoes model.
 */
class ClassesOperacoesController extends Controller
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
     * Lists all ClassesOperacoes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClassesOperacoesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ClassesOperacoes model.
     * @param int $id Id
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
     * Creates a new ClassesOperacoes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ClassesOperacoes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ClassesOperacoes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id Id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ClassesOperacoes model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id Id
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


        //return $this->redirect(['index']);
    }

    /**
     * Finds the ClassesOperacoes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id Id
     * @return ClassesOperacoes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ClassesOperacoes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
