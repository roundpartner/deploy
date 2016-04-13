<?php

class ServerTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new \RoundPartner\Test\Mocks\Container();
        $entity = new \RoundPartner\Deploy\Plan\Entity\Plan();
        $entity->full_name = 'symfony/yaml';
        $this->container->getCloud()->queue('deploy_dev')->addMessage($entity);
    }

    public function testCreateInstance()
    {
        $server = new \RoundPartner\Deploy\Server\Server($this->container, \RoundPartner\Deploy\Server\Server::RUN_ONCE);
        $this->assertInstanceOf('\RoundPartner\Deploy\Server\Server', $server);
    }

    public function testRunsOnce()
    {
        $server = $this->getMockBuilder('\RoundPartner\Deploy\Server\Server')
            ->setConstructorArgs(array($this->container, \RoundPartner\Deploy\Server\Server::RUN_ONCE))
            ->setMethods(array('runPlan'))
            ->getMock();
        $server->expects($this->once())
            ->method('runPlan')
        ->with($this->isInstanceOf('\RoundPartner\Deploy\Plan\Entity\Plan'));
        $server->dispatch();
    }
}
