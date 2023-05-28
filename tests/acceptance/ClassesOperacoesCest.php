<?php

namespace app\tests\functional;

use FunctionalTester;

class ClassesOperacoesCest
{

    public function _before(FunctionalTester $I)
    {

        $I->amOnPage('/site/login');
        $I->fillField(['name' => 'LoginForm[username]'], 'admin');
        $I->fillField(['name' => 'LoginForm[password]'], 'admin');
        // $I->submitForm('form#login', ['username' => 'admin', 'password' => 'admin']);
        // sleep(1);
        $I->click('Acessar');
    }
    public function testCriaNovaClasse(FunctionalTester $I)
    {

        // $I->amOnPage('/site/login');

        $I->amOnPage('/config/classes-operacoes/create');
        //$I->submitForm('form#login', ['username' => 'admin', 'password' => 'admin']);
        // sleep(1);
        /* $I->submitForm('form#login', ['username' => 'admin', 'password' => 'admin']);
        $I->see('INVEST');
        $I->amOnPage('/config/classes-operacoes/create');*/

        // echo $I->comment($I->grabFromCurrentUrl());
        // exit();
        // $I->pause();
        //$I->submitForm('form#login', ['username' => 'admin', 'password' => 'admin']);

        $I->see("Cria Classes Operacoes");

        //$I->submitForm('form#classesOperacoes', ['nome' => 'testeClasseOperacao']);

        /* $I->click('Login');
        $I->fillField('Username', 'Miles');
        $I->fillField('Password', 'Davis');*/
        //$I->submitForm('form#classesOperacoes', ['nome' => 'testeClasseOperacao']);

        // classes_operacoes
        // $I->see('Cria Classes Operacoes');
        //$I->click('Enter');
        //$I->see('Hello, Miles', 'h1');
        // $I->seeEmailIsSent(); // only for Symfony
    }
}
