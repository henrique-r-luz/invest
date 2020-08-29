<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \app\models\Ativo;
use yii\web\JsExpression;
use app\lib\componentes\FabricaNotificacao;
use \app\models\Sincroniza;
use app\models\service\IndexService;
use yii\helpers\Url;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {
        $indexService = new IndexService();
        $indexService->createGraficos();
        return $this->render('index', [
                    'dadosCategoria' =>$indexService->getDadosCategoria(), 
                    'dadosPais'=>$indexService->getDadosPais(),
                    'dadosAtivo' => $indexService->getDadosAtivo(),
                    'dadosTipo' => $indexService->getDadosTipo(),
                    'dadosAcoes' => $indexService->getDadosAcaoes(),
                    'patrimonioBruto' =>$indexService->getPatrimonioBruto(),
                    'valorCompra' =>$indexService->getValorCompra(),
                    'lucro_bruto' =>$indexService->getLucro() ,
        ]);
    }

}
