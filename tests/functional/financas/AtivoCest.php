<?php

namespace app\tests\functional\financas;

use app\models\financas\Ativo;
use FunctionalTester;

class AtivoCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }


    public function  testCreate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/ativo/create');
        $I->submitForm(
            '#form_ativo',
            [
                'Ativo[nome]' => 'nome ativo',
                'Ativo[codigo]' => 'TEST3',
                'Ativo[pais]' => 'BR',
                'Ativo[tipo]' => 'Ações',
                'Ativo[categoria]' => 'Renda Variável',
                'Ativo[classe_atualiza_id]' => '1'
            ]
        );
        $I->seeRecord(Ativo::class, ['codigo' => 'TEST3']);
    }


    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/ativo/update?id=14');
        $I->submitForm(
            '#form_ativo',
            [
                'Ativo[nome]' => 'Banco inter',
                'Ativo[codigo]' => 'BIDI3',
                'Ativo[pais]' => 'BR',
                'Ativo[tipo]' => 'Ações',
                'Ativo[categoria]' => 'Renda Variável',
                'Ativo[classe_atualiza_id]' => '1'
            ]
        );
        $I->seeRecord(Ativo::class, ['codigo' => 'BIDI3']);
    }


    public function testView(FunctionalTester $I)
    {
        $I->amOnPage('/financas/ativo/view?id=26');
        $I->see("Nome");
        $I->see("Tesouro ipca 2035");
    }
}
