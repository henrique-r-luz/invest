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

        $idOperacao2 = 783;
        $respEsperado2 = [
            'quantidade' => 97,
            'valor_compra' =>  2067.69,
            'valor_bruto' => 3968.27
        ];


        $idOperacao3 = 783;
        $respEsperado3 = [
            'quantidade' => 97,
            'valor_compra' =>  2067.69,
            'valor_bruto' => 3968.27
        ];

        return [
            'Remove a última operação de compra de um ativo' => [$idOperacao1, $respEsperado1],
            'Remove a última operação de venda de um ativo' => [$idOperacao2, $respEsperado2],
            //'Remove a última operação de desdobramento mais de um ativo' => [$idOperacao2, $respEsperado2]
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
