<?php

namespace app\controllers;

use app\models\dashboard\DashBoardSearch;
use app\models\dashboard\GraficoCategoria;
use app\models\dashboard\GraficoTipo;
use app\models\service\IndexService;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \app\models\dashboard\GraficoPais;
use  \app\models\dashboard\GraficoAtivo;
use const YII_ENV_TEST;

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
                // 'class' => ActionException::class,
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
        $dashBoardSearch = new DashBoardSearch();
        $dados = $dashBoardSearch->search();
        $graficoCategoria = new GraficoCategoria($dados);
        $graficoTipo = new GraficoTipo($dados);
        $graficoPais = new GraficoPais($dados);
        $graficoAtivo = new GraficoAtivo($dados);
        
        $indexService = new IndexService();
        $indexService->createGraficos();
   
        return $this->render('index', [
                    'dadosCategoria' => $graficoCategoria->montaGrafico(),//$indexService->getDadosCategoria(),
                    'dadosPais' => $graficoPais->montaGrafico(),
                    'dadosAtivo' => $graficoAtivo->montaGrafico(),
                    'dadosTipo' => $graficoTipo->montaGrafico(),
                    'dadosAcoes' => $indexService->getDadosAcaoes(),
                    'patrimonioBruto' => $indexService->getPatrimonioBruto(),
                    'valorCompra' => $indexService->getValorCompra(),
                    'lucro_bruto' => $indexService->getLucro(),
                    'dadosAcoesPais'=>$indexService->getDadosAcaoPais(),
        ]);
    }

   
}
