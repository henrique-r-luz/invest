<?php

namespace app\tests\functional\admin;

use app\models\admin\User;
use FunctionalTester;

class AdminCest
{

    public function _before(FunctionalTester $I)
    {
        $I->login();
    }


    public function  testCreate(FunctionalTester $I)
    {
        $I->amOnPage('/admin/user/create');
        $I->submitForm(
            '#form_user',
            [
                'UserForm[username]' => 'teste',
                'UserForm[grupo]' => 'admin',
                'UserForm[password]' => 'teste',
                'UserForm[confirma]' => 'teste',
            ]
        );

        $I->seeRecord(User::class, ['username' => 'teste']);
    }


    public function  testUpdate(FunctionalTester $I)
    {
        $I->amOnPage('/admin/user/update?id=2');
        $I->submitForm(
            '#form_user',
            [
                'UserForm[username]' => 'admin',
                'UserForm[grupo]' => 'admin',
                'UserForm[password]' => 'teste',
                'UserForm[confirma]' => 'teste',
            ]
        );
        $I->see('Visualiza User');
    }


    public function testView(FunctionalTester $I)
    {

        $I->amOnPage('/admin/user/view?id=2');
        $I->see("Username");
        $I->see("admin");
    }
}
