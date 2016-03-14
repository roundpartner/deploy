<?php

class DeployTest extends PHPUnit_Framework_TestCase
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
     *
     * @dataProvider \Providers\RequestProvider::requestProvider()
     */
    public function testDispatch($headers, $body, $secret)
    {
        $request = new \RoundPartner\Deploy\Request($headers, $body);
        $deploy = new \RoundPartner\Deploy\Deploy($request, $secret, $this->container);
        $this->assertTrue($deploy->dispatch());
    }

    /**
     * @param string[] $headers
     * @param string $body
     * @param string $secret
     *
     * @dataProvider \Providers\RequestProvider::requestProviderNoPlan()
     */
    public function testDispatchPlanDoesNotExist($headers, $body, $secret)
    {
        $request = new \RoundPartner\Deploy\Request($headers, $body);
        $deploy = new \RoundPartner\Deploy\Deploy($request, $secret, $this->container);
        $this->assertFalse($deploy->dispatch());
    }

}