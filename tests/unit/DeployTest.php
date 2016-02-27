<?php

class DeployTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \Deploy\Deploy
     */
    protected $deploy;

    public function setUp()
    {
        parent::setUp();

    }

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testDispatch($headers, $body, $secret)
    {
        $this->deploy = new \Deploy\Deploy($headers, $body, $secret);
        $this->assertTrue($this->deploy->dispatch());
    }

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testVerifyRequest($headers, $body, $secret)
    {
        $this->deploy = new \Deploy\Deploy($headers, $body, $secret);
        $this->assertTrue($this->deploy->verifyRequest());
    }

}