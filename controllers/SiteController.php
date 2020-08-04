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


        $this->sincroniza();

        $totalPatrimonio = Ativo::find()
                ->andWhere(['>', 'quantidade', 0])
                ->sum('valor_bruto');

        $ativos = Ativo::find()
                ->orderBy(['valor_bruto' => SORT_DESC])
                ->andWhere(['>', 'quantidade', 0])
                ->all();

        //gráfico por categorias
        $dadosCategoria = [];
        $this->graficoCategoria($totalPatrimonio, $dadosCategoria);

        //gráfico por tipo
        $dadosAtivo = [];
        $this->graficoTipo($ativos, $totalPatrimonio, $dadosTipo);
        
        //grafico por País
        $dadosPais = [];
        $this->graficoPais($totalPatrimonio, $dadosPais);
        
        //grafico por ativo
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
        //gráfico de ações ações
        $dadosAcoes = [];
        $acoes = Ativo::find()
                ->where(['tipo' => \app\lib\Tipo::ACOES])
                ->andWhere(['>', 'quantidade', 0])
                ->andWhere(['<>', 'valor_bruto', 0])
                ->all();
        $totalAcoes = Ativo::find()
                ->where(['tipo' => \app\lib\Tipo::ACOES])
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
                ->andWhere(['ativo' => true])
                ->sum('valor_bruto');
        
         $somaCompra = Ativo::find()
                ->andWhere(['ativo' => true])
                ->sum('valor_compra');
        //valor de compra
      
        $lucro = $patrimonioBruto - $somaCompra;
        $formatter = \Yii::$app->formatter;
        $lucro = $formatter->asCurrency($lucro);
        $formatter = \Yii::$app->formatter;
        $valorCompra = $formatter->asCurrency($somaCompra);
        $formatter = \Yii::$app->formatter;
        $patrimonioBruto = $formatter->asCurrency($patrimonioBruto);
        return $this->render('index', [
                    'dadosCategoria' => $dadosCategoria,
                    'dadosPais'=>$dadosPais,
                    'dadosAtivo' => $dadosAtivo,
                    'dadosTipo' => $dadosTipo,
                    'dadosAcoes' => $dadosAcaoes,
                    'patrimonioBruto' => $patrimonioBruto,
                    'valorCompra' => $valorCompra,
                    'lucro_bruto' => $lucro,
        ]);
    }

    private function graficoCategoria($totalPatrimonio, &$dadosCategoria) {
        $this->montaGraficoCategoria(\app\lib\Categoria::RENDA_FIXA, $totalPatrimonio, 0, $dadosCategoria);
        $this->montaGraficoCategoria(\app\lib\Categoria::RENDA_VARIAVEL, $totalPatrimonio, 1, $dadosCategoria);
    }

    private function graficoTipo($ativos, $totalPatrimonio, &$dadosTipo) {


        // $tipos = Tipo::find()->all();
        $dadosTipo = [];
        $this->montaGraficoTipo(\app\lib\Tipo::ACOES, $totalPatrimonio, 0, $dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::CDB, $totalPatrimonio, 1, $dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::DEBENTURES, $totalPatrimonio, 2, $dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::FUNDOS_INVESTIMENTO, $totalPatrimonio, 3, $dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::TESOURO_DIRETO, $totalPatrimonio, 4, $dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::Criptomoeda, $totalPatrimonio, 5, $dadosTipo);
    }
    
     private function graficoPais($totalPatrimonio, &$dadosPais) {
        $this->montaGraficoPais(\app\lib\Pais::BR, $totalPatrimonio, 0, $dadosPais);
        $this->montaGraficoPais(\app\lib\Pais::US, $totalPatrimonio, 1, $dadosPais);
    }

    /**
     * sincroniza valores mobiliários 
     */
    public function sincroniza() {
        $msg = '';
        $sincroniza = new Sincroniza();

        list($resp, $msg) = $sincroniza->easy();
        if ($resp == false) {
            FabricaNotificacao::create('rank', ['ok' => $resp,
                'titulo' => 'Renda fixa Easynveste falhou!',
                'mensagem' => 'Renda fixa Easynveste não foi atualizados !</br>' . $msg,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
        }
        list($resp, $msg) = $sincroniza->clearAcoes();
        if ($resp == false) {
            FabricaNotificacao::create('rank', ['ok' => $resp,
                'titulo' => 'Operações ações Falhou!',
                'mensagem' => 'As operações de ações Falharam !.<br>' . $msg,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
        }

        list($resp, $msg) = $sincroniza->cotacaoAcao();
        if ($resp == false) {
            FabricaNotificacao::create('rank', ['ok' => $resp,
                'titulo' => 'Cotação açoes falhou!',
                'mensagem' => 'A Cotação açoes não foram atualizados !</br>' . $msg,
                'action' => Yii::$app->controller->id . '/' . Yii::$app->controller->action->id])->envia();
        }
    }

    private function montaGraficoCategoria($categoria, $totalPatrimonio, $cor, &$dadosCategoria) {
        $fatia = [];
        $valorAtivoCategoria = Ativo::find()->where(['categoria' => $categoria])
                ->sum('valor_bruto');
        $fatia['name'] = $categoria;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoCategoria / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosCategoria[] = $fatia;
    }
    
    
     private function montaGraficoPais($pais, $totalPatrimonio, $cor, &$dadosPais) {
        $fatia = [];
        $valorAtivoPais = Ativo::find()->where(['pais' => $pais])
                ->sum('valor_bruto');
        $fatia['name'] = $pais;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoPais / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosPais[] = $fatia;
    }

    private function montaGraficoTipo($tipo, $totalPatrimonio, $cor, &$dadosTipo) {
        $fatia = [];
        $valorAtivoCategoria = Ativo::find()->where(['tipo' => $tipo])
                ->sum('valor_bruto');
        $fatia['name'] = $tipo;
        if ($totalPatrimonio == 0) {
            $totalPatrimonio = 1;
        } else {
            $fatia['y'] = round((($valorAtivoCategoria / $totalPatrimonio) * 100));
        }
        $fatia['color'] = new JsExpression('Highcharts.getOptions().colors[' . $cor . ']');
        $dadosTipo[] = $fatia;
    }

}
