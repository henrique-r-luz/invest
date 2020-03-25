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
use app\lib\componentes\FabricaNotificacao;

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

         
          $this->sicroniza();
        /*list($resp, $msg) = $this->sicroniza();
        if ($resp == true) {
            Yii::$app->session->setFlash('success', $msg);
        } else {
            Yii::$app->session->setFlash('danger', $msg);
        }*/
        $totalPatrimonio = Ativo::find()
                ->sum('valor_bruto');

        //gráfico por categorias
        $dadosCategoria = [];
        // foreach ($categorias as $id => $categoria) {
        $this->montaGraficoCategoria(\app\lib\Categoria::RENDA_FIXA,$totalPatrimonio,0,$dadosCategoria);
        $this->montaGraficoCategoria(\app\lib\Categoria::RENDA_VARIAVEL,$totalPatrimonio,1,$dadosCategoria);
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
       // $tipos = Tipo::find()->all();
        $dadosTipo = [];
        $this->montaGraficoTipo(\app\lib\Tipo::ACOES,$totalPatrimonio,0,$dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::CDB,$totalPatrimonio,1,$dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::DEBENTURES,$totalPatrimonio,2,$dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::FUNDOS_INVESTIMENTO,$totalPatrimonio,3,$dadosTipo);
        $this->montaGraficoTipo(\app\lib\Tipo::TESOURO_DIRETO,$totalPatrimonio,4,$dadosTipo);
       
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
        if ($resp == false ) {
             FabricaNotificacao::create('rank', 
                  ['ok' => $resp, 
                   'titulo' => 'Cotação açoes falhou!', 
                    'mensagem' => 'A Cotação açoes foram atualizados !</br>'.$msg, 
                    'action' =>Yii::$app->controller->id.'/'.Yii::$app->controller->action->id])->envia(); 
        }
        list($resp, $msg) = $sincroniza->easy();
        if ($resp == false) {
            FabricaNotificacao::create('rank', 
                  ['ok' => $resp, 
                   'titulo' => 'Renda fixa Easynveste falhou!', 
                    'mensagem' => 'Renda fixa Easynveste não foi atualizados !</br>'.$msg, 
                    'action' =>Yii::$app->controller->id.'/'.Yii::$app->controller->action->id])->envia();
        }
        list($resp, $msg) = $sincroniza->clearAcoes();
        if ($resp == false) {
              FabricaNotificacao::create('rank', 
                  ['ok' => $resp, 
                   'titulo' => 'Operações ações Falhou!</br>'.$msg, 
                    'mensagem' => 'As operações de ações Falharam !.<br>'.$msg, 
                    'action' =>Yii::$app->controller->id.'/'.Yii::$app->controller->action->id])->envia(); 
        }
        /*list($resp, $msg) = $sincroniza->fundamentos();
        if ($resp == false) {
             FabricaNotificacao::create('rank', 
                  ['ok' => $resp, 
                   'titulo' => 'Fundamentos ações falhou!', 
                    'mensagem' => 'Os dados do site fundamentos não foram atualizados !</br>'.$msg, 
                    'action' =>Yii::$app->controller->id.'/'.Yii::$app->controller->action->id])->envia();
        }*/
         
        //$msg = 'O dados foram sincronizados com sucesso. ';
       
    }
    
    private function montaGraficoCategoria($categoria,$totalPatrimonio,$cor,&$dadosCategoria){
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
    
    
    private function montaGraficoTipo($tipo,$totalPatrimonio,$cor,&$dadosTipo){
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
