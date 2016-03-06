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
        $request = new \RoundPartner\Deploy\Request($headers, $body);
        $deploy = new \RoundPartner\Deploy\Deploy($request, $secret, new \RoundPartner\Deploy\Container());
        $this->assertTrue($deploy->dispatch());
    }

}