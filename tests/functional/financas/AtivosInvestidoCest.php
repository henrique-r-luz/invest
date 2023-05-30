<?php

namespace app\tests\functional\financas;

use app\models\financas\ItensAtivo;
use FunctionalTester;

class AtivosInvestidoCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }


    public function testCreate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/itens-ativo/create');
        $I->submitForm(
            '#form_ativos_investido',
            [
                'ItensAtivo[investidor_id]' => '2',
                'ItensAtivo[ativo_id]' => '20',
                'ItensAtivo[ativo]' => true,

            ]
        );
        $I->seeRecord(ItensAtivo::class, ['investidor_id' => '2', 'ativo_id' => '20']);
    }

    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/itens-ativo/update?id=35');
        $I->submitForm(
            '#form_ativos_investido',
            [
                'ItensAtivo[investidor_id]' => '1',
                'ItensAtivo[ativo_id]' => '34',
                'ItensAtivo[ativo]' => 0,

            ]
        );
        $I->seeRecord(ItensAtivo::class, ['investidor_id' => '1', 'ativo_id' => '34', 'ativo' => false]);
    }


    public function testView(FunctionalTester $I)
    {
        $I->amOnPage('/financas/itens-ativo/view?id=22');
        $I->see("Código");
        $I->see("Tesouro IPCA+ 2026-IPCA-15/08/2026");
    }
}
