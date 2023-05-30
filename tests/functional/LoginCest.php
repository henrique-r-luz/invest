<?php

namespace app\tests\functional;


use FunctionalTester;
use app\models\config\ClassesOperacoes;

class LoginCest
{

    public function testLogin(FunctionalTester $I)
    {

        $I->amOnPage('/site/login');
        $I->fillField(['name' => 'LoginForm[username]'], 'admin');
        $I->fillField(['name' => 'LoginForm[password]'], 'admin');
        $I->click('Acessar');

        $I->amOnPage('/config/classes-operacoes/create');
        $I->fillField(['name' => 'ClassesOperacoes[nome]'], 'testeClasseOperacao1');
        $I->click("Salvar");
        $I->seeRecord(ClassesOperacoes::class, ['nome' => 'testeClasseOperacao1']);
        //$I->see('testeClasseOperacao1');
    }
}
