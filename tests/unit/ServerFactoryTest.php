<?php

namespace RoundPartner\Test\Unit;

use GuzzleHttp\Psr7\Response;
use RoundPartner\Test\TestCase;

class ServerFactoryTest extends TestCase
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
    }

    public function testSingleRun()
    {
        $server = $this->getSingleRunServer();
        $this->assertInstanceOf('\RoundPartner\Deploy\Server\Server', $server);
    }

    /**
     * @param Response[] $responses
     *
     * @dataProvider \RoundPartner\Test\Providers\SeqProvider::get()
     *
     * @throws \Exception
     */
    public function testDispatchSingleRun($responses)
    {
        $client = $this->getClientMock($responses);
        $this->container->getSeq()->setClient($client);
        $server = $this->getSingleRunServer();
        $this->assertTrue($server->dispatch());
    }

    /**
     * @param Response[] $responses
     *
     * @dataProvider \RoundPartner\Test\Providers\SeqProvider::get()
     *
     * @throws \Exception
     */
    public function testDispatchMultipleRun($responses)
    {
        $client = $this->getClientMock($responses);
        $this->container->getSeq()->setClient($client);
        $server = \RoundPartner\Deploy\Server\ServerFactory::multiRun($this->container, 3, 0);
        $this->assertTrue($server->dispatch());
    }

    protected function getSingleRunServer()
    {
        return \RoundPartner\Deploy\Server\ServerFactory::singleRun($this->container);
    }
}
