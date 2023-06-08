<?php

namespace tests\unit\app\models\sincronizar\services\atualizaAtivos\rendaVariavel;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\models\financas\ItensAtivo;
use app\models\sincronizar\services\atualizaAtivos\rendaVariavel\RecalculaAtivos;

class RecalculaAtivosTest extends Unit
{
    protected function _before()
    {
        /**
         * usuário admin
         */
        Yii::$app->user->login(User::findOne(Yii::$app->params['userAdminPadraoId']), 1000);
    }

    // tests
    public function testCalculaPrecoCompra()
    {
        $atualizaRendaVariavel = new RecalculaAtivos();
        $atualizaRendaVariavel->alteraIntesAtivo();

        /**
         * itens ativo WEGE3
         */
        $itensAtivo = ItensAtivo::findOne(27);
        $valor_compra  = round($itensAtivo->valor_compra, 2);
        $respWEGE3 =  ($valor_compra == 1509.96);

        /**
         * Xpml11 
         */
        $itensAtivo = ItensAtivo::findOne(12);
        $valor_compra  = round($itensAtivo->valor_compra, 2);
        $respXPML11 =  ($valor_compra == 7105.83);

        /**
         * Xplgl11 
         */
        $itensAtivo = ItensAtivo::findOne(11);
        $valor_compra  = round($itensAtivo->valor_compra, 2);
        $respXPLG11 =  ($valor_compra == 8406.59);

        $this->assertEquals(($respWEGE3 && $respXPML11 && $respXPLG11), true);
    }
}
