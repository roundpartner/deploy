<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Test\TestCase;
use GuzzleHttp\Psr7\Response;

class ServerTest extends TestCase
{

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new \RoundPartner\Test\Mocks\Container();
    }

    public function testCreateInstance()
    {
        $server = new \RoundPartner\Deploy\Server\Server($this->container, \RoundPartner\Deploy\Server\Server::RUN_ONCE);
        $this->assertInstanceOf('\RoundPartner\Deploy\Server\Server', $server);
    }

    /**
     * @param Response[] $responses
     *
     * @dataProvider \RoundPartner\Test\Providers\SeqProvider::get()
     *
     * @throws \Exception
     */
    public function testRunsOnce($responses)
    {
        $client = $this->getClientMock($responses);
        $this->container->getSeq()->setClient($client);
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
