<?php

namespace app\tests\acceptance;

use AcceptanceTester;
use app\models\config\ClassesOperacoes;

class ClassesOperacoesCest
{

    public function _before(AcceptanceTester $I)
    {
        // $I->login();
    }
    public function testCriaNovaClasse(AcceptanceTester $I)
    {
        /*$I->amOnPage('/config/classes-operacoes/create');
        $I->fillField(['name' => 'ClassesOperacoes[nome]'], 'testeClasseOperacao');
        $I->click("Salvar");
        $I->see('testeClasseOperacao');*/
    }
}
