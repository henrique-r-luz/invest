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
        $idOperacao1 = 837;
        $respEsperado1 = [
            'quantidade' => 119,
            'valor_compra' => 12602.30,
            'valor_bruto' => 12162.99
        ];

        return [
            'Altera operações de venda no meio da lista' => [$idOperacao1, $respEsperado1],
        ];
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
        $respGerado =  $salvaOperacoes->update($idOperacao);
        $this->assertEquals($respGerado, $respEsperado);
    }
}
