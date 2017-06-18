<?php

namespace RoundPartner\Test\Unit;

class BootstrapTest extends \PHPUnit_Framework_TestCase
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
     * @dataProvider \RoundPartner\Test\Providers\RequestProvider::requestProvider()
     */
    public function testBootstrap($headers, $body, $secret)
    {
        $bootstrap = new \RoundPartner\Deploy\Bootstrap($headers, $body, $secret, $this->container);
        $this->assertTrue($bootstrap->dispatch());
    }
}
