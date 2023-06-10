<?php

namespace tests\unit\app\models\financas\atualizaItensAtivos;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\tests\_support\unit\SalvaOperacoes;

class RendaVariavelDeleteTest extends Unit
{

    protected function _before()
    {
        /**
         * usuário admin
         */
        Yii::$app->user->login(User::findOne(Yii::$app->params['userAdminPadraoId']), 1000);
    }

    public function providerRendaVariavelDelete()
    {
        //deleta a última compra do itens_ativo_id = 31
        $idOperacao1 = 806;

        $respEsperado1 = [
            'quantidade' => 615,
            'valor_compra' => 4823.10,
            'valor_bruto' => 4993.80
        ];

        return [
            'Remove a última operação de compra de um ativo' => [$idOperacao1, $respEsperado1]
        ];
    }


    /**
     * @dataProvider providerRendaVariavelDelete
     * @param [type] $respEsperado
     * @return void
     * @author Henrique Luz
     */
    public function testAtualizaItensAtivoDeleteOperacao($idOperacao, $respEsperado)
    {
        $salvaOperacoes = new SalvaOperacoes();
        $respGerado =  $salvaOperacoes->delete($idOperacao);
        $this->assertEquals($respGerado, $respEsperado);
    }
}
