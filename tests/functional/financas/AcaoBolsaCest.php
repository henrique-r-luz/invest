<?php

namespace app\tests\functional\financas;

use app\models\financas\AcaoBolsa;
use FunctionalTester;

class AcaoBolsaCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }


    public function  testCreate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/acao-bolsa/create');
        $I->submitForm(
            '#form_acao_bolsa',
            [
                'AcaoBolsa[nome]' => 'aaaa',
                'AcaoBolsa[codigo]' => 'AAAA',
                'AcaoBolsa[setor]' => 'teste setor',
                'AcaoBolsa[cnpj]' => '345345234523',
            ]
        );
        $I->seeRecord(AcaoBolsa::class, ['codigo' => 'AAAA']);
    }


    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/acao-bolsa/update?id=7');
        $I->submitForm(
            '#form_acao_bolsa',
            [
                'AcaoBolsa[nome]' => 'Aliansce',
                'AcaoBolsa[codigo]' => 'ALSC2',
                'AcaoBolsa[setor]' => 'Shoppings',
                'AcaoBolsa[cnpj]' => '06.082.980/0001-03',
            ]
        );
        $I->seeRecord(AcaoBolsa::class, ['codigo' => 'ALSC2']);
    }


    public function testView(FunctionalTester $I)
    {
        $I->amOnPage('/financas/acao-bolsa/view?id=7');
        $I->see("Nome");
        $I->see("Aliansce");
    }
}
