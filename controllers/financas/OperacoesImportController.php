<?php

namespace app\controllers\financas;

use Yii;
use Exception;
use Throwable;
use yii\web\Response;
use yii\web\Controller;
use app\lib\CajuiHelper;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\lib\helpers\InvestException;
use Mpdf\Container\NotFoundException;
use app\models\financas\OperacoesImport;
use app\models\financas\OperacoesImportSearch;
use app\models\financas\service\operacoesImport\OperacoesImportService;

/**
 * OperacoesImportController implements the CRUD actions for OperacoesImport model.
 */
class OperacoesImportController extends Controller
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
     * Lists all OperacoesImport models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OperacoesImportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OperacoesImport model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new OperacoesImport model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $operacoesImportService = new OperacoesImportService();

            if ($operacoesImportService->load(Yii::$app->request->post())) {
                $operacoesImportService->save();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $operacoesImportService->getModel()->id]);
            }
        } catch (InvestException $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Erro ao salvar operação import! ' . $e->getMessage());
            $operacoesImportService->removeArquivo();
        } catch (Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado! ');
            $operacoesImportService->removeArquivo();
        } finally {
            $operacoesImportService->getModel()->arquivo = null;
            return $this->render('create', [
                'model' => $operacoesImportService->getModel(),
            ]);
        }
        /*return $this->render('create', [
            'model' => $operacoesImportService->getModel(),
        ]);*/
    }


    /**
     * Download nota de negociação
     *
     * @param [type] $id
     * @return void
     * @author Henrique Luz
     */
    public function actionDownload($id)
    {
        $notaNegociacao = OperacoesImport::findOne($id);
        if (empty($notaNegociacao)) {
            throw new NotFoundException('Nota de negociação não encontrada.');
        }
        $url = Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $notaNegociacao->hash_nome . '.' . $notaNegociacao->extensao;
        return Yii::$app->response->sendFile($url, 'nota_negociação_' . $notaNegociacao->id . '.' . $notaNegociacao->extensao);
    }


    public function actionGetArquivo($id)
    {
        try {
            $model = $this->findModel($id);
            \Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
            \Yii::$app->response->headers->add('content-type', OperacoesImport::get($model->extensao));
            \Yii::$app->response->data = file_get_contents(Yii::getAlias('@' . OperacoesImport::DIR) . '/' . $model->hash_nome . '.' . $model->extensao);
            return \Yii::$app->response;
        } catch (InvestException $e) {
            \Yii::$app->response->format = yii\web\Response::FORMAT_RAW;
            return \Yii::$app->response;
        } catch (Throwable) {
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado! ');
        }
        // return Yii::$app->response->sendFile(Yii::getAlias('@' . $model->diretorio) . '/' . $model->hash_nome . '.' . $model->extensao)->send();
        //return 
    }

    /**
     * Deletes an existing OperacoesImport model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $model = $this->findModel($id);
            $operacoesImportService = new OperacoesImportService($model);
            $operacoesImportService->delete();
            $transaction->commit();
            //Yii::$app->session->setFlash('success', 'Registro deletado com sucesso! ');
            $response = [
                'resp' => true,
                'msg' => true
            ];
        } catch (InvestException $e) {
            $transaction->rollBack();
            $response = [
                'resp' => false,
                'msg' => $e->getMessage()
            ];
            //Yii::$app->session->setFlash('danger', 'Erro ao deletera registro. ' . $e->getMessage());
        } catch (Throwable $e) {
            // Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado! ');
            $response = [
                'resp' => false,
                'msg' => 'Ocorreu um erro inesperado! '
            ];
        } finally {
            return $response;
        }
    }

    /**
     * Finds the OperacoesImport model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return OperacoesImport the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OperacoesImport::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
