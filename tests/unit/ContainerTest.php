<?php

class ContainerTest extends PHPUnit_Framework_TestCase
{

    public function testGetConfig()
    {
        $container = new \RoundPartner\Deploy\Container();
        $this->assertInstanceOf('\RoundPartner\Deploy\Config', $container->getConfig());
    }
}