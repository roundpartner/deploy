<?php

namespace RoundPartner\Test\Unit;

use GuzzleHttp\Psr7\Response;
use RoundPartner\Test\TestCase;

class DeployTest extends TestCase
{

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    protected $container;

    public function setUp()
    {
        $this->container = new \RoundPartner\Test\Mocks\Container();
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
    public function testDispatch($headers, $body, $secret, $responses)
    {
        $client = $this->getClientMock($responses);
        $this->container->getSeq()->setClient($client);
        $request = new \RoundPartner\Deploy\Request($headers, $body);
        $deploy = new \RoundPartner\Deploy\Deploy($request, $secret, $this->container);
        $this->assertTrue($deploy->dispatch());
    }

    /**
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     *
     * @dataProvider \RoundPartner\Test\Providers\RequestProvider::requestProviderNoPlan()
     *
     * @throws \Exception
     */
    public function testDispatchPlanDoesNotExist($headers, $body, $secret)
    {
        $request = new \RoundPartner\Deploy\Request($headers, $body);
        $deploy = new \RoundPartner\Deploy\Deploy($request, $secret, $this->container);
        $this->assertFalse($deploy->dispatch());
    }
}
