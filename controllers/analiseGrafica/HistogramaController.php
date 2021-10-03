<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers\analiseGrafica;

use app\models\analiseGrafica\Histograma;
use yii\filters\VerbFilter;
use yii\web\Controller;
use \app\models\service\HistogramaService;
use Yii;

/**
 * Description of Histograma
 *
 * @author henrique
 */
class HistogramaController extends Controller {
    //put your code here

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    
     public function actionIndex() {
        $modelService = new HistogramaService();
        if($modelService->load(Yii::$app->request->post())){
            $modelService->geraDados();
        }
        return $this->render('index', [
                    'model' => $modelService->getHistograma(),
                    'labelClasse'=>$modelService->getLabelClasse(),
                    'histogramaClasse'=>$modelService->getClasseHistograma(),
                   
        ]);
    }

}
