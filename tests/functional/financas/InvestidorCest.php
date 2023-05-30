<?php

namespace app\tests\functional\financas;

use app\models\financas\Investidor;
use FunctionalTester;

class InvestidorCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }

    public function  testCreate(FunctionalTester $I)
    {

        $I->amOnPage('/financas/investidor/create');
        $I->submitForm(
            '#form_investidor',
            [
                'Investidor[cpf]' => '12345678912',
                'Investidor[nome]' => 'test investido',

            ]
        );
        $I->seeRecord(Investidor::class, ['cpf' => '12345678912']);
    }

    public function  testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/investidor/update?id=1');
        $I->submitForm(
            '#form_investidor',
            [
                'Investidor[cpf]' => '91999375599',
                'Investidor[nome]' => 'anderson mota teste',

            ]
        );
        $I->seeRecord(Investidor::class, ['nome' => 'anderson mota teste']);
    }

    public function  testView(FunctionalTester $I)
    {
        $I->amOnPage('/financas/investidor/view?id=2');
        $I->see("Nome");
        $I->see("ana vitoria");
    }
}
