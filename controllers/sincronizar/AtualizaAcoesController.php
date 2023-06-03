<?php

namespace app\controllers\sincronizar;

use Yii;
use yii\web\Controller;
use app\lib\CajuiHelper;
use yii\helpers\Console;
use yii\filters\VerbFilter;
use app\models\sincronizar\AtualizaAcoes;
use app\lib\dicionario\StatusAtualizacaoAcoes;
use app\models\sincronizar\AtualizaAcoesSearch;
use Throwable;

/**
 * AtualizaAcoesController implements the CRUD actions for AtualizaAcoes model.
 */
class AtualizaAcoesController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AtualizaAcoes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AtualizaAcoesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new AtualizaAcoes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AtualizaAcoes();
        $model->status = StatusAtualizacaoAcoes::PROCESSANDO;
        $model->data = date("Y-m-d H:i:s");
        if (!$model->save()) {
            Yii::$app->session->setFlash('danger', 'Erro ao salvar atualização!</br>'
                . CajuiHelper::processaErros($model->getErrors()));
            return $this->redirect('index');
        }
        try {
            $consoleCommand = Yii::$app->basePath . '/yii scraping-atualiza-acoes/page ' . $model->id;
            $backgroundCommand = Console::isRunningOnWindows() ? 'start /B ' : 'nohup ';
            $command = $backgroundCommand . 'php ' .  $consoleCommand . ' > ' . Yii::$app->basePath . '/runtime/logs/console-atualiza-acoes.log 2>&1 &';
            exec($command);
        } catch (Throwable $e) {
            $model->status = StatusAtualizacaoAcoes::FINALIZADO;
            if (!$model->save()) {
                Yii::$app->session->setFlash('danger', 'Erro!</br>'
                    . CajuiHelper::processaErros($model->getErrors()));
            }
            Yii::$app->session->setFlash('danger', 'Erro!</br>' . $e->getMessage());
        }
        return $this->redirect('index');
    }
}
