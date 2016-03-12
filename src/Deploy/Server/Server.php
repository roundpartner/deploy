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

    private $sleep;

    const SLEEP_SECONDS = 60;

    public function __construct(Container $container, $iterations, $sleep = self::SLEEP_SECONDS)
    {
        $this->container = $container;
        $this->iterations = $iterations;
        $this->sleep = $sleep;
        $this->currentIteration = 0;
    }

    public function dispatch()
    {
        while ($this->runIteration()) {
            if ($this->hasNextIteration()) {
                sleep($this->sleep);
            }
        }

        return ! $this->hasNextIteration();
    }

    protected function hasNextIteration()
    {
        return $this->currentIteration < $this->iterations;
    }

    protected function runIteration()
    {
        if ($this->currentIteration >= $this->iterations) {
            return false;
        }

        $cloudConfig = $this->container->getConfig()->get('cloud');
        $plans = $this->container->getCloud()->getMessages($cloudConfig['name']);
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
