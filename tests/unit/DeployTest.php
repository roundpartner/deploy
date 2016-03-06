<?php

class DeployTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testDispatch($headers, $body, $secret)
    {
        $deploy = new \Deploy\Deploy($headers, $body, $secret, new \RoundPartner\Deploy\Container());
        $this->assertTrue($deploy->dispatch());
    }

}