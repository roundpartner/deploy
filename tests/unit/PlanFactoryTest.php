<?php

class PlanFactoryTest extends PHPUnit_Framework_TestCase
{

    public function testCreatePlan()
    {
        $request = new \RoundPartner\Deploy\Entity\Request();
        $request->repository = new \RoundPartner\Deploy\Entity\Repository();
        $request->repository->full_name = 'symfony/yaml';
        $container = new \RoundPartner\Deploy\Container();
        $this->assertInstanceOf('\RoundPartner\Deploy\Plan\Plan', \RoundPartner\Deploy\Plan\PlanFactory::createPlan($request, $container));
    }

}