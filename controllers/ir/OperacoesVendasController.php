<?php

namespace app\controllers\ir;

use Yii;
use yii\web\Controller;
use app\models\ir\bensDireitos\FormBensDireitos;
use app\models\ir\operacoesVendas\OperacoesVendasQuery;
use app\models\ir\operacoesVendas\OperacoesVendasArrayData;

class OperacoesVendasController extends Controller
{

    public function actionIndex()
    {
        $formBensDireitos = new FormBensDireitos();
        $formBensDireitos->load(Yii::$app->request->get());
        $operacoesVendasQuery = new OperacoesVendasQuery($formBensDireitos);
        $operacoesVendasArrayData = new OperacoesVendasArrayData($operacoesVendasQuery->query(), $formBensDireitos->ano);
        return $this->render('index', [
            'formBensDireitos' => $formBensDireitos,
            'provider' => $operacoesVendasArrayData->getProviderDetalhado(),
            'providerFii' =>  $operacoesVendasArrayData->getProviderResumoFii(),
            'providerAcoes' =>  $operacoesVendasArrayData->getProviderResumoAcoes()
        ]);
    }
}
