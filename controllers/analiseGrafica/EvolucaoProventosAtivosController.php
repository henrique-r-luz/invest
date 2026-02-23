<?php

namespace app\controllers\analiseGrafica;

use app\models\analiseGrafica\EvolucaoProventosAtivos;
use app\models\financas\ItensAtivo;
use Yii;
use yii\base\Controller;

class EvolucaoProventosAtivosController extends Controller
{

    public function actionIndex()
    {
        $itensAtivo = new ItensAtivo();
        $itensAtivo->id = Yii::$app->request->get('ItensAtivo')['id'] ?? null;
        $evolucaoProventosAtivos = new EvolucaoProventosAtivos($itensAtivo);
        $evolucaoProventosAtivos->getProvider();
        return $this->render(
            'index',
            [
                'itensAtivo' => $itensAtivo,
                'dados' => $evolucaoProventosAtivos
            ]
        );
    }
}
