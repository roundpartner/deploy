<?php

class ServerTest extends PHPUnit_Framework_TestCase
{

    public function testCreateInstance()
    {
        $server = new \RoundPartner\Deploy\Server\Server(new \RoundPartner\Deploy\Container(), \RoundPartner\Deploy\Server\Server::RUN_ONCE);
        $this->assertInstanceOf('\RoundPartner\Deploy\Server\Server', $server);
    }
}