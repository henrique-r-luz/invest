<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use app\models\Histograma;
use yii\filters\VerbFilter;
use yii\web\Controller;

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
        $model = new Histograma();

        return $this->render('index', [
                   
                    'model' => $model,
        ]);
    }

}
