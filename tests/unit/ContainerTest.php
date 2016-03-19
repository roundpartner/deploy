<?php

class ContainerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \RoundPartner\Deploy\Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new \RoundPartner\Deploy\Container();
    }

    public function testGetConfig()
    {
        $this->assertInstanceOf('\RoundPartner\Deploy\Config', $this->container->getConfig());
    }

    public function testGetCloud()
    {
        $this->assertInstanceOf('\RoundPartner\Cloud\Cloud', $this->container->getCloud());
    }

    public function testGetLogger()
    {
        $this->container->getLogger();
    }
}
