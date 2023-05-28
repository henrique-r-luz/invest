<?php

namespace app\tests\acceptance;


use AcceptanceTester;

class ClassesOperacoesACCCest
{

    public function _before(AcceptanceTester $I)
    {

        $I->amOnPage('/site/login');
        $I->fillField(['name' => 'LoginForm[username]'], 'admin');
        $I->fillField(['name' => 'LoginForm[password]'], 'admin');
        $I->click('Acessar');
    }
    public function testCriaNovaClasse(AcceptanceTester $I)
    {

       

        $I->amOnPage('/config/classes-operacoes/create');
       

        $I->see("Cria Classes Operacoes");

    }
}
