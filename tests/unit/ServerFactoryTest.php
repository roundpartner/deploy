<?php

class ServerFactoryTest extends PHPUnit_Framework_TestCase
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
        $this->container->getCloud()->addMessage('deploy_dev', $entity);
    }

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

    public function testDispatchMultpleRun()
    {
        $server = \RoundPartner\Deploy\Server\ServerFactory::multiRun($this->container, 3);
        $this->assertTrue($server->dispatch());
    }

    protected function getSingleRunServer()
    {
        return \RoundPartner\Deploy\Server\ServerFactory::singleRun($this->container);
    }
}
