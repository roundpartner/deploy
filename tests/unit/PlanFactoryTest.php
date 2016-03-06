<?php

class PlanFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCreatePlan()
    {
        $request = new \Deploy\Entity\Request();
        $request->repository = new \Deploy\Entity\Repository();
        $request->repository->full_name = 'symfony/yaml';
        $container = new \RoundPartner\Deploy\Container();
        $this->assertInstanceOf('\Deploy\Plan\Plan', \Deploy\Plan\PlanFactory::createPlan($request, $container));
    }

}