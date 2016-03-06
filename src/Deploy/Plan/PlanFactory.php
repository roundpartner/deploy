<?php

namespace RoundPartner\Deploy\Plan;

use RoundPartner\Deploy\Entity\Request;
use RoundPartner\Deploy\Container;

class PlanFactory
{
    public static function createPlan(Request $request, Container $container)
    {
        return new Plan($request, $container);
    }

}
