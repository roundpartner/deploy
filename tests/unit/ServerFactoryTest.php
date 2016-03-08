<?php

class ServerFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testSingleRun()
    {
        $server = $this->getSingleRunServer();
        $this->assertInstanceOf('\RoundPartner\Deploy\Server\Server', $server);
    }

    public function testDispatchSingleRun()
    {
        $server = $this->getSingleRunServer();
        $this->assertTrue($server->dispatch());
    }

    protected function getSingleRunServer()
    {
        return \RoundPartner\Deploy\Server\ServerFactory::singleRun(new \RoundPartner\Deploy\Container());
    }
}