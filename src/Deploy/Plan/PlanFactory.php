<?php

namespace Deploy\Plan;

use Deploy\Entity\Request;

class PlanFactory
{
    public static function createPlan(Request $request)
    {
        return new Plan($request);
    }

}
