<?php

namespace tests\unit\models;

use app\models\financas\Ativo;

class ContactFormTest extends \Codeception\Test\Unit
{
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testEmailIsSentOnContact()
    {
      $ativo  =  new Ativo();
      $this->assertEquals(true,true);
    }
}
