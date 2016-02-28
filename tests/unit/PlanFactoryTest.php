<?php

class PlanFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCreatePlan()
    {
        $request = new \Deploy\Entity\Request();
        $this->assertInstanceOf('\Deploy\Plan\Plan', \Deploy\Plan\PlanFactory::createPlan($request));
    }

}