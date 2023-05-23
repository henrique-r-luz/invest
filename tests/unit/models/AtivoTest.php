<?php

namespace tests\unit\app\models;

use app\models\financas\Ativo;
use Codeception\Test\Unit;

class AtivoTest extends Unit
{
    protected function _before()
    {
    }

    // tests
    public function testMe()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }

    public function testMe1()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }

    public function testMe2()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }

    public function testMe3()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }

    public function testMe4()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }

    public function testMe5()
    {
        $ativo =  Ativo::findOne(5);
        $this->assertEquals($ativo->nome, 'BANCO AGIBANK - 121.50% - 20/04/2020');
    }
}
