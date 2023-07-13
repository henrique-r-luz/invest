<?php

namespace app\commands;

use Throwable;
use app\lib\CajuiHelper;
use yii\console\Controller;
use app\commands\helper\LerPagina;
use app\lib\config\ValorDollar;
use app\models\sincronizar\AtualizaAcoes;
use app\lib\dicionario\StatusAtualizacaoAcoes;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\AtualizaRendaVariavel;
use Yii;

/**
 * Atualiza ativos dos tipo renda variável cadastrados no sistema
 *
 * @author Henrique Luz
 */
class ScrapingAtualizaAcoesController extends Controller
{
    private AtualizaAcoes $atualizaAcoes;


    public function actionPage(int $id)
    {
        try {
            $this->atualizaAcoes = AtualizaAcoes::findOne($id);
            $this->botPreco();
            $atualizaRendaVariavel = new AtualizaRendaVariavel();
            $atualizaRendaVariavel->alteraIntesAtivo();
            echo "atualiza itens ativos" . \PHP_EOL;
        } catch (Throwable $ex) {
            $erro = $ex->getMessage();
            echo $erro . \PHP_EOL;
        } finally {
            $this->atualizaAcoes->status = StatusAtualizacaoAcoes::FINALIZADO;
            if (!$this->atualizaAcoes->save()) {
                $erro = CajuiHelper::processaErros($this->atualizaAcoes->getErrors());
                echo $erro;
            }
            $cache = Yii::$app->cache;
            $cache->delete(ValorDollar::key);
            ValorDollar::getCotacaoDollar();
        }
    }


    private function botPreco()
    {
        $lerPagina = new  LerPagina($this->atualizaAcoes);
        $lerPagina->analisaSalvaPreco();
    }
}
