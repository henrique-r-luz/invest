<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\financas\Ativo;
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
        $filtroServico->load(Yii::$app->request->get());
        $provider = new ArrayDataProvider([
            'allModels' => $filtroServico->fabricaFiltro(Yii::$app->request->queryParams),
            'pagination' => [
                'pageSize' => 30,
            ],
        ]);
        return $this->render('index', [
                    'model' => $filtroServico->getFiltroEmpresa(),
                    'searchModel' => $filtroServico->getFiltroEmpresaDados(),
                    'provaider' => $provider,
        ]);
    }

}
