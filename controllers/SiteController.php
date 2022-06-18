<?php

namespace app\controllers;

use Yii;
use const YII_ENV_TEST;
use yii\web\Controller;
use app\models\admin\LoginForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\financas\Proventos;
use app\models\dashboard\GraficoFiis;
use app\models\dashboard\GraficoPais;
use app\models\dashboard\GraficoTipo;
use app\models\dashboard\GraficoAcoes;
use app\models\dashboard\GraficoAtivo;
use app\models\dashboard\DashBoardSearch;
use app\models\dashboard\GraficoAcaoPais;
use app\models\dashboard\GraficoCategoria;
use yii\web\ForbiddenHttpException;
use app\lib\helpers\SiteHelper;

class SiteController extends Controller
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
                    'logout' => ['GET'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
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
    public function actionIndex()
    {


        $dashBoardSearch = new DashBoardSearch();
        $dados = $dashBoardSearch->search();
        $graficoCategoria = new GraficoCategoria($dados);
        $graficoTipo = new GraficoTipo($dados);
        $graficoPais = new GraficoPais($dados);
        $graficoAtivo = new GraficoAtivo($dados);
        $graficoAcaoPais = new GraficoAcaoPais($dados);
        $graficoAcoes = new GraficoAcoes($dados);
        $graficoFii = new GraficoFiis($dados);
        $formatter = Yii::$app->formatter;
        $patrimonioBruto = 0;
        $valorCompra = 0;
        $lucro = 0;
        $proventos = $formatter->asCurrency(Proventos::find()->sum('valor'));
        if (!empty($dados)) {
            $patrimonioBruto = $formatter->asCurrency(round($dados[0]['valor_total'], 5));
            $valorCompra = $formatter->asCurrency(round($dados[0]['valor_compra'], 5));
            $lucro = $formatter->asCurrency(round(($dados[0]['valor_total'] - $dados[0]['valor_compra']), 5));
        }

        return $this->render('index', [
            'dadosCategoria' => $graficoCategoria->montaGrafico(), //$indexService->getDadosCategoria(),
            'dadosPais' => $graficoPais->montaGrafico(),
            'dadosAtivo' => $graficoAtivo->montaGrafico(),
            'dadosTipo' => $graficoTipo->montaGrafico(),
            'dadosAcoes' => $graficoAcoes->montaGrafico(),
            'patrimonioBruto' => $patrimonioBruto,
            'valorCompra' => $valorCompra,
            'lucro_bruto' => $lucro,
            'proventos' => $proventos,
            'dadosAcoesPais' => $graficoAcaoPais->montaGrafico(),
            'dadosFiis' => $graficoFii->montaGrafico(),
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'main-login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return SiteHelper::urlDepoisLogin($this);
        }
        return $this->render(
            'login',
            ['model' => $model]
        );
    }

    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();

            return $this->redirect('login');
        }

        return $this->redirect('index');
    }


    public function actionError()
    {
        return $this->render(
            'error',
            []
        );
    }
}
