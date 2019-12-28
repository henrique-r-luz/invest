<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use \app\models\FiltroDataRelatorio;
use Yii;
use app\models\OperacaoSearch;

/**
 * Description of RelatorioController
 *
 * @author henrique
 */
class RelatorioController extends Controller {
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

    public function actionRelatorioAporte() {
        $model = new FiltroDataRelatorio();
        $model->dataInicio = null;
        $model->dataFim = null;
        $dataProvider = [];
        $searchModel = new OperacaoSearch();
        if ($model->load(Yii::$app->request->post())) {
            $dataProvider = $searchModel->searchContAporte($model);
        }
        return $this->render('relatorio-aporte', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                    'model' => $model,
        ]);
    }

}
