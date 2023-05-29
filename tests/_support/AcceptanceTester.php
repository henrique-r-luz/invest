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
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;


    public function login()
    {
        $this->amOnPage('/site/login');
        $this->fillField(['name' => 'LoginForm[username]'], 'admin');
        $this->fillField(['name' => 'LoginForm[password]'], 'admin');
        $this->click('Acessar');
    }

    /**
     * Define custom actions here
     */
}
