<?php

namespace app\controllers;

use app\lib\componentes\AccountNotification;
use app\models\AcaoBolsa;
use app\models\AcaoBolsaSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\lib\componentes\FabricaNotificacao;

/**
 * AcaoBolsaController implements the CRUD actions for AcaoBolsa model.
 */
class AcaoBolsaController extends Controller {

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
     * Lists all AcaoBolsa models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new AcaoBolsaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AcaoBolsa model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AcaoBolsa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new AcaoBolsa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing AcaoBolsa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * define um rank para cada ação cadastrada
     */
    public function actionRank() {
        /**
         * função mínimos quadrados
         */
        /* $samples = [[60], [61], [62], [63], [65]];
          $targets = [10, 9, 9.5, 7.3, 5.5];

          $regression = new LeastSquares();
          $regression->train($samples, $targets);
          print_r ($regression->getCoefficients());
          echo ' = '. $regression->predict([30]);
          exit(); */

        //FabricaNotificacao::create('rank', ['ok' => true, 'titulo' => 'Rank Atualizado!', 'mensagem' => 'Teste mensagem !!!', 'action' =>Yii::$app->controller->id.'/'.Yii::$app->controller->action->id])->envia();
        if(Yii::$app->queue->push(new \app\lib\backgroud\Teste())){
            echo 'ok';
            exit();
        }else{
            echo 'não ok';
            exit();
        }
        //return $this->redirect(['index']);
    }

    /**
     * Deletes an existing AcaoBolsa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AcaoBolsa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AcaoBolsa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = AcaoBolsa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
