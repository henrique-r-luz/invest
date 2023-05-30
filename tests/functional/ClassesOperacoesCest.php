<?php

namespace app\tests\functional;


use Yii;
use FunctionalTester;
use app\models\config\ClassesOperacoes;

class ClassesOperacoesCest
{


    public function _before(FunctionalTester $I)
    {
        $I->login();
    }
    public function testCreate(FunctionalTester $I)
    {

        $I->amOnPage('/config/classes-operacoes/create');
        $I->submitForm('#form-classesOperacoes', ['ClassesOperacoes[nome]' => 'testeClasseOperacao1']);
        $I->seeRecord(ClassesOperacoes::class, ['nome' => 'testeClasseOperacao1']);
    }

    public function testView(FunctionalTester $I)
    {
        $I->amOnPage('/config/classes-operacoes/view?id=1');
        $I->see("Nome");
        $I->see('app\lib\config\atualizaAtivos\rendaVariavel\CalculaPorMediaPreco');
    }


    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/config/classes-operacoes/update?id=1');
        $I->submitForm('#form-classesOperacoes', ['ClassesOperacoes[nome]' => 'app\lib\config\atualizaAtivos\rendaVariavel\CalculaPorMediaPreco1']);
        $I->see("Nome");
        $I->see('app\lib\config\atualizaAtivos\rendaVariavel\CalculaPorMediaPreco1');
    }
}
