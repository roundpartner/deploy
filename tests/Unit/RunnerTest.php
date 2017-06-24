<?php

namespace RoundPartner\Test\Unit;

use RoundPartner\Deploy\Runner;
use RoundPartner\Test\Mocks\Container;

class RunnerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    private $container;

    /**
     * @var \RoundPartner\Deploy\Runner
     */
    protected $process;

    public function setUp()
    {
        $this->container = new Container();
        $this->process = new Runner($this->container->getLogger());
    }

    public function testGetInstance()
    {
        $this->assertInstanceOf('\RoundPartner\Deploy\Runner', $this->process);
    }

    public function testRunProcess()
    {
        $result = $this->process->run('ls', '.');
        $this->assertTrue($result);
    }
}
