<?php

namespace app\tests\functional;


use FunctionalTester;
use app\models\config\ClassesOperacoes;

class ClassesOperacoesCest
{


    public function _before(FunctionalTester $I)
    {
        $I->login();
    }
    public function testClassesOperacoesCreate(FunctionalTester $I)
    {

        $I->amOnPage('/config/classes-operacoes/create');
        $I->submitForm('#form-classesOperacoes', ['ClassesOperacoes[nome]' => 'testeClasseOperacao1']);
        $I->seeRecord(ClassesOperacoes::class, ['nome' => 'testeClasseOperacao1']);
    }


    public function testDelete(FunctionalTester $I)
    {
    }
}
