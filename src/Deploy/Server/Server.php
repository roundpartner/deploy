<?php

namespace RoundPartner\Deploy\Server;

use RoundPartner\Deploy\Container;
use RoundPartner\Deploy\Plan\PlanFactory;

class Server
{

    const RUN_ONCE = 1;

    protected $iterations;

    protected $container;

    private $currentIteration;

    public function __construct(Container $container, $iterations)
    {
        $this->container = $container;
        $this->iterations = $iterations;
        $this->currentIteration = 0;
    }

    public function dispatch()
    {
        while ($this->runIteration()) {

        }

        return $this->currentIteration >= $this->iterations;
    }

    protected function runIteration()
    {
        if ($this->currentIteration >= $this->iterations) {
            return false;
        }

        $plans = $this->container->getCloud()->getMessages('deploy_dev');
        $this->runPlans($plans);

        ++$this->currentIteration;
        return true;
    }

    /**
     * @param \RoundPartner\Deploy\Plan\Entity\Plan[] $planEntities
     */
    protected function runPlans($planEntities)
    {
        foreach ($planEntities as $planEntity) {
            $plan = PlanFactory::createWithEntity($this->container, $planEntity);
            $plan->deploy();
        }
    }
}
