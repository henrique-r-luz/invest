<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */


class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;


    /* public function login(FunctionalTester $I)
    {
        $I->amOnPage('/site/login');
        $I->submitForm('form#login', ['username' => 'admin', 'password' => 'admin']);
        $I->saveSessionSnapshot('login');
    }*/
}
