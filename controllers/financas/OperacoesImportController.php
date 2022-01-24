<?php

namespace app\controllers\financas;

use Yii;
use yii\base\Response;
use yii\web\Controller;
use app\lib\CajuiHelper;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\financas\OperacoesImport;
use app\models\financas\OperacoesImportSearch;


/**
 * OperacoesImportController implements the CRUD actions for OperacoesImport model.
 */
class OperacoesImportController extends Controller
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
     * Lists all OperacoesImport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OperacoesImportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OperacoesImport model.
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
     * Creates a new OperacoesImport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OperacoesImport();

        if ($model->load(Yii::$app->request->post())) {
            $model->arquivo = UploadedFile::getInstance($model, 'arquivo');
            if (!$model->saveUpload()) {
                $erro = CajuiHelper::processaErros($model->getErrors());
                Yii::$app->session->setFlash('danger', 'Erro ao salvar Ativo!</br>' . $erro);
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing OperacoesImport model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
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


    public function actionGetArquivo($id)
    {
        $model = $this->findModel($id);
        \Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
        \Yii::$app->response->headers->add('content-type',OperacoesImport::get($model->extensao));
        \Yii::$app->response->data = file_get_contents(Yii::getAlias('@' . $model->diretorio) . '/' . $model->hash_nome . '.' . $model->extensao);
        return \Yii::$app->response;
        // return Yii::$app->response->sendFile(Yii::getAlias('@' . $model->diretorio) . '/' . $model->hash_nome . '.' . $model->extensao)->send();
        //return 
    }

    /**
     * Deletes an existing OperacoesImport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->deleteUpload();

        return $this->redirect(['index']);
    }

    /**
     * Finds the OperacoesImport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OperacoesImport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OperacoesImport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
