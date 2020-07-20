<?php

namespace app\controllers;

use Yii;
use app\models\Ativo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\Aporte;
use yii\data\ArrayDataProvider;
use app\models\FiltroEmpresa;
use \app\models\service\FiltroEmpresaService;

/**
 * AtivoController implements the CRUD actions for Ativo model.
 */
class AnaliseEmpresaController extends Controller {

    const tomadaDescisao = 35; // define a porcentagem de patrimônio investido em renda variável

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
        $filtroServico = new FiltroEmpresaService();
        
         $provider = new ArrayDataProvider([
          // 'allModels' => $dados,
          'pagination' => false
          ]); 

        if ($filtroServico->load(Yii::$app->request->post())) {

            $provider = new ArrayDataProvider([
                'allModels' => $filtroServico->filtraAguiaConservador(),
                'pagination' => false
            ]);
        }

        return $this->render('index', [
                    'model' => $filtroServico->getFiltroEmpresa(),
                    'provaider' => $provider,
        ]);
    }

}
