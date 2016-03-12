<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Entity\Request;
use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\Plan\Entity\Plan as PlanEntity;

class PlanFactory
{
    public static function createPlan(Container $container, Request $request)
    {
        return new Plan($container, $request->repository->full_name);
    }

    public static function createWithEntity(Container $container, PlanEntity $plan)
    {
        return new Plan($container, $plan->full_name);
    }
}
