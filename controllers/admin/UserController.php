<?php

namespace app\controllers\admin;

use app\controllers\admin\services\UserServices;
use Yii;
use app\models\admin\User;
use app\models\admin\UserForm;
use app\models\admin\UserSearch;
use Exception;
use Throwable;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $userServices = new UserServices();
        try {
            $transaction = Yii::$app->db->beginTransaction();
            if ($userServices->load(Yii::$app->request->post())) {
                $userServices->save();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $userServices->getUser()->id]);
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger', 'Erro ao criar Usuário! </br>' . $e->getMessage());
            $transaction->rollBack();
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado! ');
            $transaction->rollBack();
        }


        return $this->render('create', [
            'model' => $userServices->getUser(),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $userServices = new UserServices($model);
        $userServices->loadUpdate(Yii::$app->request->post());
        try {
            $transaction = Yii::$app->db->beginTransaction();
            if (Yii::$app->request->isPost) {
                $userServices->save();
                $transaction->commit();
                return $this->redirect(['view', 'id' => $userServices->getUser()->id]);
            }
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger', 'Erro ao criar Usuário! </br>' . $e->getMessage());
            $transaction->rollBack();
        } catch (Throwable) {
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado! ');
            $transaction->rollBack();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $transaction = Yii::$app->db->beginTransaction();
            $user  = $this->findModel($id);
            $userServices = new UserServices($user);
            $userServices->delete();
            $transaction->commit();
        } catch (Exception $e) {
            Yii::$app->session->setFlash('danger','Erro ao remover Usuário! </br>'.$e->getMessage());
            $transaction->rollBack();
        } catch (Throwable $e) {
            Yii::$app->session->setFlash('danger', 'Ocorreu um erro inesperado! ');
            $transaction->rollBack();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserForm::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
