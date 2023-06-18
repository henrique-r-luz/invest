<?php

namespace tests\unit\app\models\financas\atualizaItensAtivos;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\tests\_support\unit\SalvaOperacoes;

class RendaVariavelUpdateTest extends Unit
{

    protected function _before()
    {
        /**
         * usuário admin
         */
        Yii::$app->user->login(User::findOne(Yii::$app->params['userAdminPadraoId']), 1000);
    }

    public function providerRendaVariavelUpdate()
    {
    }


    /**
     * @dataProvider providerRendaVariavelUpdate
     * @param [type] $respEsperado
     * @return void
     * @author Henrique Luz
     */
    public function testAtualizaItensAtivoUpdateOperacao($idOperacao, $respEsperado)
    {
        $salvaOperacoes = new SalvaOperacoes();
        $respGerado =  $salvaOperacoes->delete($idOperacao);
        $this->assertEquals($respGerado, $respEsperado);
    }
}
