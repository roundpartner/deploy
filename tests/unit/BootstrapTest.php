<?php

class BootstrapTest extends PHPUnit_Framework_TestCase
{

    /**
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testBootstrap($headers, $body, $secret)
    {
        $bootstrap = new \RoundPartner\Deploy\Bootstrap($headers, $body, $secret);
        $bootstrap->dispatch();
    }
}