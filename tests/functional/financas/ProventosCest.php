<?php

namespace app\tests\functional\financas;

use app\models\financas\Proventos;
use FunctionalTester;

class ProventosCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }


    public function testCreate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/proventos/create');
        $I->submitForm(
            '#form_proventos',
            [
                'Proventos[itens_ativos_id]' => '8',
                'Proventos[data]' => '2023-05-31 09:00:00',
                'Proventos[valor]' => '100',
                'Proventos[movimentacao]' => '1',
            ]
        );
        $I->seeRecord(
            Proventos::class,
            [
                'itens_ativos_id' => '8',
                'data' => '2023-05-31 09:00:00',
                'valor' => 100
            ]
        );
    }


    public function testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/financas/proventos/update?id=327');
        $I->submitForm(
            '#form_proventos',
            [
                'Proventos[itens_ativos_id]' => '8',
                'Proventos[data]' => '2023-03-31 15:05:20',
                'Proventos[valor]' => '5',
                'Proventos[movimentacao]' => '1',
            ]
        );
        $I->seeRecord(
            Proventos::class,
            [
                'itens_ativos_id' => '8',
                'data' => '2023-03-31 15:05:20',
                'valor' => 5
            ]
        );
    }

    public function testView(FunctionalTester $I)
    {
        $I->amOnPage('/financas/proventos/view?id=327');
        $I->see("valor");
        $I->see("2,81");
    }
}
