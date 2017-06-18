<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Entity\Request;
use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\Plan\Entity\Plan as PlanEntity;

class PlanFactory
{
    /**
     * @param Container $container
     * @param Request $request
     *
     * @return Plan
     */
    public static function createPlan(Container $container, Request $request)
    {
        return new Plan($container, $request->repository->full_name, $container->getMaker());
    }

    /**
     * @param Container $container
     * @param PlanEntity $plan
     *
     * @return Plan
     */
    public static function createWithEntity(Container $container, PlanEntity $plan)
    {
        return new Plan($container, $plan->full_name, $container->getMaker());
    }
}
