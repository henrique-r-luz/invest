<?php


namespace app\controllers\financas;

use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\financas\Preco;

class PrecoController extends Controller
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


    public function actionIndex(){

        $preco = new Preco();
        return $this->render('index', [
            //'searchModel' => $searchModel,
            'dataProvider' => $preco->getArrayProvaider(),
        ]);
    }
}