<?php

namespace RoundPartner\Test\Unit;

class PlanFactoryTest extends \PHPUnit_Framework_TestCase
{

    const FULL_NAME = 'symfony/yaml';

    const INSTANCE_NAME = 'RoundPartner\Deploy\Plan\Plan';

    public function testCreatePlan()
    {
        $request = new \RoundPartner\Deploy\Entity\Request();
        $request->repository = new \RoundPartner\Deploy\Entity\Repository();
        $request->repository->full_name = self::FULL_NAME;
        $container = new \RoundPartner\Test\Mocks\Container();
        $this->assertInstanceOf(self::INSTANCE_NAME, \RoundPartner\Deploy\Plan\PlanFactory::createPlan($container, $request));
    }

    public function testCreateWithEntity()
    {
        $container = new \RoundPartner\Test\Mocks\Container();
        $entity = new \RoundPartner\Deploy\Plan\Entity\Plan();
        $entity->full_name = self::FULL_NAME;
        $this->assertInstanceOf(self::INSTANCE_NAME, \RoundPartner\Deploy\Plan\PlanFactory::createWithEntity($container, $entity));
    }
}
