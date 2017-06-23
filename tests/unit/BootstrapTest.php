<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\Bootstrap;
use RoundPartner\Test\Providers\RequestProvider;
use RoundPartner\Test\Mocks\Container;

class BootstrapTest extends \PHPUnit_Framework_TestCase
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
     *
     * @dataProvider requestProvider
     */
    public function testBootstrap($headers, $body, $secret)
    {
        $bootstrap = new Bootstrap($headers, $body, $secret, $this->container);
        $this->assertTrue($bootstrap->dispatch());
    }

    public function requestProvider()
    {
        return RequestProvider::requestProvider();
    }
}
