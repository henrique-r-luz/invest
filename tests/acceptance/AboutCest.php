<?php

use yii\helpers\Url;

class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->wait(30);
        $I->see('Patrimônio');
       
    }
}
