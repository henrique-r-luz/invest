<?php

namespace app\controllers\ir;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\ir\bensDireitos\FormBensDireitos;
use app\models\ir\bensDireitos\BensDireitosQuery;
use app\models\ir\bensDireitos\BensDireitosArrayData;

class BensDireitosController extends Controller
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

    public function actionIndex()
    {
        $formBensDireitos = new FormBensDireitos();
        $formBensDireitos->load(Yii::$app->request->get());
        $bensDireitosQuery = new BensDireitosQuery($formBensDireitos);
        $bensDireitosArrayData = new BensDireitosArrayData($bensDireitosQuery->query(), $formBensDireitos->ano);
        return $this->render('index', [
            'formBensDireitos' => $formBensDireitos,
            'provider' => $bensDireitosArrayData->getProvider()
        ]);
    }
}
