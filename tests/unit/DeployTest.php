<?php

class DeployTest extends PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testDispatch($headers, $body, $secret)
    {
        $deploy = new \Deploy\Deploy($headers, $body, $secret);
        $this->assertTrue($deploy->dispatch());
    }

    /**
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testVerifyRequest($headers, $body, $secret)
    {
        $deploy = new \Deploy\Deploy($headers, $body, $secret);
        $this->assertTrue($deploy->verifyRequest());
    }

}