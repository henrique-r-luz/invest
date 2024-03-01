<?php

namespace app\controllers\ir;

use Yii;
use yii\web\Controller;
use app\models\ir\bensDireitos\FormBensDireitos;
use app\models\ir\operacoesVendas\VendaOperacoesSearch;

class OperacoesVendasController extends Controller
{

    public function actionIndex()
    {
        $formBensDireitos = new FormBensDireitos();
        $formBensDireitos->load(Yii::$app->request->get());
        if (empty($formBensDireitos->ano)) {
            return $this->render('index', [
                'formBensDireitos' => $formBensDireitos,
                'provider' => null,
                'providerFii' =>  null,
                'providerAcoes' =>  null
            ]);
        }
        $vendaOperacoesSearch = new VendaOperacoesSearch();
        $providerOperacoes = $vendaOperacoesSearch->search($formBensDireitos);
        list($resumoAcoes, $resumoFii) =  $vendaOperacoesSearch->resumoDados();

        return $this->render('index', [
            'formBensDireitos' => $formBensDireitos,
            'provider' => $providerOperacoes,
            'providerFii' =>  $resumoFii,
            'providerAcoes' =>  $resumoAcoes
        ]);
    }
}
