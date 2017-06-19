<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\Bootstrap;

class BootstrapTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    protected $container;


    public function setUp()
    {
        require_once dirname(__DIR__) . '/Providers/RequestProvider.php';
        $this->container = new \RoundPartner\Test\Mocks\Container();
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
        return \RoundPartner\Test\Providers\RequestProvider::requestProvider();
    }
}
