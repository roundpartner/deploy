<?php

namespace RoundPartner\Test\Unit;

class PlanTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \RoundPartner\Deploy\Plan\Plan
     */
    private $plan;

    /**
     * @var \RoundPartner\Test\Mocks\Container
     */
    private $container;

    public function setUp()
    {
        $this->container = new \RoundPartner\Test\Mocks\Container();
        $this->plan = new \RoundPartner\Deploy\Plan\Plan($this->container, 'symfony/yaml', new \RoundPartner\Test\Mocks\Maker('maker'));
    }

    public function testGetEntity()
    {
        $this->assertInstanceOf('\RoundPartner\Deploy\Plan\Entity\Plan', $this->plan->getPlan());
    }

    public function testCreateRepoFolder()
    {
        $this->assertTrue($this->plan->createRepoFolder('/tmp/test'));
    }

    public function testCheckoutRepo()
    {
        $this->plan->directory = uniqid('deploy');
        $this->assertTrue($this->plan->checkoutRepo());
    }

    public function testDeploy()
    {
        $this->assertTrue($this->plan->deploy());
    }

    public function testDeployWithNoCommand()
    {
        $this->plan->getPlan()->command = '';
        $this->assertTrue($this->plan->deploy());
    }

    public function testDeployFails()
    {
        $this->plan->getPlan()->command = 'false';
        $this->assertFalse($this->plan->deploy());
    }

    public function testPlanDoesNotExist()
    {
        $this->setExpectedException('\Exception', 'No configuration found');
        new \RoundPartner\Deploy\Plan\Plan($this->container, 'wont/exist', new \RoundPartner\Test\Mocks\Maker('maker'));
    }
}
