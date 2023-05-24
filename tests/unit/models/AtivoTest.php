<?php

namespace tests\unit\app\models;

use Yii;
use app\models\admin\User;
use Codeception\Test\Unit;
use app\models\financas\Ativo;

class AtivoTest extends Unit
{
    protected function _before()
    {
        Yii::$app->user->login(User::findOne(2), 1000);
    }

    // tests
    public function testMe()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }
}
