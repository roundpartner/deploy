<?php

class DeployTest extends PHPUnit_Framework_TestCase
{

    protected $deploy;

    public function setUp()
    {
        parent::setUp();
        $this->deploy = new \Deploy\Deploy($this->getTestHeaders(), $this->getTestBody());
    }

    public function testVerifyRequest()
    {
        $this->assertTrue($this->deploy->verifyRequest());
    }

    protected function getTestHeaders()
    {
        return array(
            'X-Hub-Signature' => 'sha1=79e7904c5cc7d82b0b07b3a68e1bdbf8abf5e251',
        );
    }

    protected function getTestBody()
    {
        return '';
    }
}