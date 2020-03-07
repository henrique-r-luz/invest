<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use \app\models\Ativo;
use \app\models\Categoria;
use yii\web\JsExpression;
use \app\models\Tipo;
use yii\i18n\Formatter;

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


        list($resp, $msg) = $this->sicroniza();
        if ($resp == true) {
            Yii::$app->session->setFlash('success', $msg);
        } else {
            Yii::$app->session->setFlash('danger', $msg);
        }
        $totalPatrimonio = Ativo::find()
                ->sum('valor_bruto');

        //gráfico por categorias
        //$categorias = Categoria::find()->all();
        $dadosCategoria = [];
        // foreach ($categorias as $id => $categoria) {
        $fatia = [];
        $valorAtivoCategoria = Ativo::find()->where(['categoria' => \app\lib\Categoria::RENDA_FIXA])
                ->sum('valor_bruto');
        $fatia['name'] = \app\lib\Categoria::RENDA_FIXA;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoCategoria / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . 0 . ']');
        $dadosCategoria[] = $fatia;
        
        $fatia = [];
        $valorAtivoCategoria = Ativo::find()->where(['categoria' => \app\lib\Categoria::RENDA_VARIAVEL])
                ->sum('valor_bruto');
        $fatia['name'] = \app\lib\Categoria::RENDA_VARIAVEL;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoCategoria / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . 1 . ']');
        $dadosCategoria[] = $fatia;
        
        //}
        //gráfico por ativos
        $ativos = Ativo::find()
                ->orderBy(['valor_bruto' => SORT_DESC])
                ->andWhere(['>', 'quantidade', 0])
                ->all();
        $dadosAtivo = [];
        foreach ($ativos as $id => $ativo) {
            $fatia = [];
            $valorAtivo = $ativo->valor_liquido;
            $fatia['name'] = $ativo->codigo;
            if ($totalPatrimonio == 0) {
                $totalPatrimonio = 1;
            } else {
                $fatia['y'] = round((($valorAtivo / $totalPatrimonio) * 100));
            }
            $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $id . ']');
            $dadosAtivo[] = $fatia;
        }
        //gráfico por tipo
        $tipos = Tipo::find()->all();
        $dadosTipo = [];
        foreach ($tipos as $id => $tipo) {
            $fatia = [];
            $valorAtivo = Ativo::find()->where(['tipo_id' => $tipo->id])
                    ->sum('valor_bruto');
            $fatia['name'] = $tipo->nome;
            if ($totalPatrimonio == 0) {
                $totalPatrimonio = 1;
            } else {
                $fatia['y'] = round((($valorAtivo / $totalPatrimonio) * 100));
            }
            $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $id . ']');
            $dadosTipo[] = $fatia;
        }

        //gráfico de ações ações
        $dadosAcoes = [];
        $acoes = Ativo::find()
                ->where(['tipo_id' => 7])
                ->andWhere(['>', 'quantidade', 0])
                ->andWhere(['<>', 'valor_bruto', 0])
                ->all();
        $totalAcoes = Ativo::find()
                ->where(['tipo_id' => 7])
                ->sum('valor_bruto');
        foreach ($acoes as $id => $acao) {
            $fatia = [];
            $valorAtivo = $acao->valor_liquido;
            $fatia['name'] = $acao->codigo;
            if ($totalPatrimonio == 0) {
                $totalPatrimonio = 1;
            } else {
                $fatia['y'] = round((($valorAtivo / $totalAcoes) * 100));
            }
            $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $id . ']');
            $dadosAcaoes[] = $fatia;
        }


        //patrimônio bruto total
        $patrimonioBruto = Ativo::find()
                ->sum('valor_bruto');
        $formatter = \Yii::$app->formatter;
        $patrimonioBruto = $formatter->asCurrency($patrimonioBruto);
        //valor de compra
        $valorCompra = Ativo::find()
                ->sum('valor_compra');
        $formatter = \Yii::$app->formatter;
        $valorCompra = $formatter->asCurrency($valorCompra);
        return $this->render('index', [
                    'dadosCategoria' => $dadosCategoria,
                    'dadosAtivo' => $dadosAtivo,
                    'dadosTipo' => $dadosTipo,
                    'dadosAcoes' => $dadosAcaoes,
                    'patrimonioBruto' => $patrimonioBruto,
                    'valorCompra' => $valorCompra,
        ]);
    }

    /**
     * sincroniza valores mobiliários 
     */
    public function sicroniza() {
        $msg = '';
        list($sincroniza) = Yii::$app->createController('sicronizar/index');
        list($resp, $msg) = $sincroniza->cotacaoAcao();
        if ($resp == false) {
            $msg = 'O sistema não pode sincronizar os dados de ações. ';
            return [false, $msg];
        }
        list($resp, $msg) = $sincroniza->easy();
        if ($resp == false) {
            $msg = 'O sistema não pode sincronizar os dados de renda fixa da easy. ';
            return [false, $msg];
        }
        list($resp, $msg) = $sincroniza->clearAcoes();
        if ($resp == false) {
            #$msg = 'O sistema não pode sincronizar os dados de renda fixa da easy. ';
            return [false, $msg];
        }
        list($resp, $msg) = $sincroniza->fundamentos();
        if ($resp == false) {
            #$msg = 'O sistema não pode sincronizar os dados de renda fixa da easy. ';
            return [false, $msg];
        }

        $msg = 'O dados foram sincronizados com sucesso. ';
        return [true, $msg];
    }

}
