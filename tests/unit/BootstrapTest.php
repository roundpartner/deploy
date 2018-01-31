<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\Bootstrap;
use RoundPartner\Test\Mocks\Container;
use GuzzleHttp\Psr7\Response;
use RoundPartner\Test\TestCase;

class BootstrapTest extends TestCase
{

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    protected $container;


    public function setUp()
    {
        $this->container = new Container();
    }

    /**
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     * @param Response[] $responses
     *
     * @dataProvider \RoundPartner\Test\Providers\RequestProvider::requestProvider()
     *
     * @throws \Exception
     */
    public function testBootstrap($headers, $body, $secret, $responses)
    {
        $client = $this->getClientMock($responses);
        $this->container->getSeq()->setClient($client);
        $bootstrap = new Bootstrap($headers, $body, $secret, $this->container);
        $this->assertTrue($bootstrap->dispatch());
    }
}
