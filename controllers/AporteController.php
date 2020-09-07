<?php

namespace app\controllers;

use app\lib\Tipo;
use app\models\Ativo;
use app\models\service\AposteService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * AtivoController implements the CRUD actions for Ativo model.
 */
class AporteController extends Controller {

    const tomadaDescisao = 100; // define a porcentagem de patrimônio investido em renda variável

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
       
        $aposteService = new AposteService();
        if ($aposteService->load(Yii::$app->request->post())) {
            $aposteService->acoesAporte();
        }
        return $this->render('index', [
                    'model' => $aposteService->getAporte(),
                    'provaider' => $aposteService->getProvider(),
        ]);
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
