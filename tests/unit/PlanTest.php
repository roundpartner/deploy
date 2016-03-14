<?php

class PlanTest extends PHPUnit_Framework_TestCase
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
        $this->plan = new \RoundPartner\Deploy\Plan\Plan($this->container, 'symfony/yaml');
    }

    public function testGetEntity()
    {
        $this->assertInstanceOf('\RoundPartner\Deploy\Plan\Entity\Plan', $this->plan->getPlan());
    }

    public function testDeploy()
    {
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
        new \RoundPartner\Deploy\Plan\Plan($this->container, 'wont/exist');
    }

}