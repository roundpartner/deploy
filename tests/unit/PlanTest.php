<?php

class PlanTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var \RoundPartner\Deploy\Plan\Plan
     */
    private $plan;

    public function setUp()
    {
        $container = new \RoundPartner\Test\Mocks\Container();
        $this->plan = new \RoundPartner\Deploy\Plan\Plan($container, 'symfony/yaml');
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

}