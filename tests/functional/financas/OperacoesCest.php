<?php

namespace app\tests\functional\financas;

use app\models\financas\Operacao;
use FunctionalTester;

class OperacoesCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }


    public function testCreate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/operacao/create');
        $I->submitForm(
            '#form_operacoes',
            [
                'Operacao[itens_ativos_id]' => '43',
                'Operacao[tipo]' => '1', //compra
                'Operacao[quantidade]' => '10',
                'Operacao[data]' => '2023-05-02 05:10:34',
                'Operacao[valor]' => '1000'

            ]
        );
        $I->seeRecord(Operacao::class, [
            'valor' => '1000',
            'itens_ativos_id' => 43,
            'data' => '2023-05-02 05:10:34',
            'quantidade' => 10,
            'tipo' => 1
        ]);
    }


    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/operacao/update?id=810');
        $I->submitForm(
            '#form_operacoes',
            [
                'Operacao[itens_ativos_id]' => '48',
                'Operacao[tipo]' => '1', //compra
                'Operacao[quantidade]' => '6',
                'Operacao[data]' => '2023-04-24 16:10:13',
                'Operacao[valor]' => '47'

            ]
        );
        $I->seeRecord(Operacao::class, [
            'valor' => '47',
            'itens_ativos_id' => 48,
            'data' => '2023-04-24 16:10:13',
            'quantidade' => 6,
            'tipo' => 1
        ]);
    }


    public function testView(FunctionalTester $I)
    {
        $I->amOnPage('/financas/operacao/view?id=810');
        $I->see("810");
        $I->see("2023-04-24 16:10:13");
    }
}
