<?php

namespace app\controllers;

use app\lib\helpers\InvestException;
use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\lib\helpers\SiteHelper;
use app\models\admin\LoginForm;
use app\models\financas\Proventos;
use app\models\dashboard\GraficoFiis;
use app\models\dashboard\GraficoPais;
use app\models\dashboard\GraficoTipo;
use app\models\dashboard\GraficoAcoes;
use app\models\dashboard\GraficoAtivo;
use app\models\dashboard\DashBoardSearch;
use app\models\dashboard\GraficoAcaoPais;
use app\models\dashboard\GraficoCategoria;
use app\models\dashboard\ValoresConsolidados;
use Throwable;

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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        try {

            $dashBoardSearch = new DashBoardSearch();
            $dados = $dashBoardSearch->search();
            $valoresTotais = $dashBoardSearch->valorTotal();
            $graficoCategoria = new GraficoCategoria($dados, $valoresTotais);
            $graficoTipo = new GraficoTipo($dados, $valoresTotais);
            $graficoPais = new GraficoPais($dados, $valoresTotais);
            $graficoAtivo = new GraficoAtivo($dados, $valoresTotais);
            $graficoAcaoPais = new GraficoAcaoPais($dados, $valoresTotais);
            $graficoAcoes = new GraficoAcoes($dados, $valoresTotais);
            $graficoFii = new GraficoFiis($dados, $valoresTotais);
            $formatter = Yii::$app->formatter;
            $patrimonioBruto = 0;
            $valorCompra = 0;
            $lucro = 0;
            $proventos = $formatter->asCurrency(Proventos::find()->sum('valor'));
            if (!empty($valoresTotais)) {
                $patrimonioBruto = $formatter->asCurrency(round(ValoresConsolidados::valorInvestido($valoresTotais), 5));
                $valorCompra = $formatter->asCurrency(round(ValoresConsolidados::valorCompra($valoresTotais), 5));
                $lucro = $formatter->asCurrency(round((ValoresConsolidados::valorInvestido($valoresTotais) - ValoresConsolidados::valorCompra($valoresTotais)), 5));
            }
        } catch (InvestException $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('danger', 'Um erro inesperado ocorreu');
        } finally {
            return $this->render('index', [
                'dadosCategoria' => $graficoCategoria->montaGrafico(),
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
